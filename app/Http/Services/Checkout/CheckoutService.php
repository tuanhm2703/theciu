<?php

namespace App\Http\Services\Checkout;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Enums\PaymentMethodType;
use App\Enums\PaymentStatus;
use App\Events\Kiot\OrderCreatedEvent as KiotOrderCreatedEvent;
use App\Events\OrderCreatedEvent;
use App\Exceptions\InventoryOutOfStockException;
use App\Http\Services\Payment\PaymentService;
use App\Models\Config;
use App\Models\PaymentMethod;
use App\Models\VoucherType;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutService {
    public static function checkout(CheckoutModel $checkoutModel) {
        DB::beginTransaction();
        $customer = $checkoutModel->getCustomer();
        try {
            if (!$customer->id) $customer->save();
            $checkoutModel->createAddress();
            $payment_method = PaymentMethod::find($checkoutModel->getPaymentMethodId());
            $order = $customer->orders()->create([
                'total' => 0,
                'subtotal' => 0,
                'origin_subtotal' => 0,
                'shipping_fee' => $checkoutModel->getShippingFee(),
                'order_status' => $payment_method->type == PaymentMethodType::COD ? OrderStatus::WAITING_TO_PICK : OrderStatus::WAIT_TO_ACCEPT,
                'sub_status' => $payment_method->type == PaymentMethodType::COD ? OrderSubStatus::PREPARING : null,
                'payment_method_id' => $checkoutModel->getPaymentMethodId(),
                'note' => $checkoutModel->getNote()
            ]);
            $order->addresses()->create([
                'type' => AddressType::SHIPPING,
                'details' => $checkoutModel->getAddress()->details,
                'province_id' => $checkoutModel->getAddress()->province_id,
                'district_id' => $checkoutModel->getAddress()->district_id,
                'ward_id' => $checkoutModel->getAddress()->ward_id,
                'full_address' => $checkoutModel->getAddress()->full_address,
                'fullname' => $checkoutModel->getAddress()->fullname,
                'phone' => $checkoutModel->getAddress()->phone,
                'featured' => 1
            ]);
            if ($checkoutModel->getInventories()->count() <= 0) {
                throw new Exception('Vui lòng chọn ít nhất 1 sản phẩm', 409);
            }
            foreach ($checkoutModel->getInventories() as $inventory) {
                $order->inventories()->attach([
                    $inventory->id => [
                        'product_id' => $inventory->product_id,
                        'quantity' => $inventory->cart_stock ?? 1,
                        'origin_price' => $inventory->price,
                        'promotion_price' => $inventory->sale_price,
                        'total' => $inventory->sale_price * $inventory->cart_stock,
                        'title' => $inventory->title,
                        'name' => $inventory->name,
                        'is_reorder' => $inventory->product->is_reorder && $inventory->stock_quantity  - $inventory->cart_stock < 0,
                        'promotion_id' => $inventory->product?->available_promotion?->id
                    ]
                ]);
                if ($inventory->stock_quantity - $inventory->cart_stock < 0 && $inventory->product->is_reorder == 0)
                    throw new InventoryOutOfStockException("Sản phẩm $inventory->name không đủ số lượng", 409);
                /* If product is not reorderable or product is reorderable and stock quantity is less
                than 0, then update stock quantity. */
            }
            foreach ($checkoutModel->getAccomInventories() as $inventory) {
                $order->inventories()->attach([
                    $inventory->id => [
                        'product_id' => $inventory->product_id,
                        'quantity' => $inventory->quantity_each_order,
                        'origin_price' => $inventory->price,
                        'promotion_price' => 0,
                        'total' => 0,
                        'title' => $inventory->title,
                        'name' => $inventory->name,
                        'is_reorder' => 0,
                        'promotion_id' => $inventory->product?->available_promotion?->id
                    ]
                ]);
                if ($inventory->stock_quantity - $inventory->quantity_each_order < 0)
                    throw new InventoryOutOfStockException("Sản phẩm $inventory->name không đủ số lượng", 409);
            }
            $order_total = $order->inventories()->sum('order_items.total');
            $rank_discount = $customer->calculateRankDiscountAmount($order_total);
            $discounted_combos = $checkoutModel->getCart()->calculateComboDiscount($checkoutModel->getItemSelected());
            $combo_discount = $discounted_combos->sum('discount_amount');
            $attach_vouchers = [];
            $order_discount_amount = 0;
            $freeship_discount_amount = 0;
            if ($discounted_combos->count() > 0) {
                foreach ($discounted_combos as $c) {
                    $order->combos()->attach($c['combo']->id, [
                        'total_discount' => $c['discount_amount'],
                        'number_of_combos' => $c['total_combo']
                    ]);
                }
            }
            if ($checkoutModel->getOrderVoucher()) {
                $order_discount_amount = $checkoutModel->getOrderVoucher()->getDiscountAmount($order_total - $rank_discount - $combo_discount);
                $order_total = $order_total - $order_discount_amount;
                $orderVoucher = $checkoutModel->getOrderVoucher();
                $attach_vouchers[$checkoutModel->getOrderVoucherId()] = [
                    'type' => $orderVoucher->voucher_type->code,
                    'amount' => $order_discount_amount,
                    'customer_id' => $customer->id
                ];
            }
            if ($checkoutModel->getFreeshipVoucher()) {
                $freeship_discount_amount = $checkoutModel->getFreeshipVoucher()->getDiscountAmount($checkoutModel->getShippingFee());
                $order_total = $order_total - $freeship_discount_amount;
                $freeshipVoucher = $checkoutModel->getFreeshipVoucher();
                $attach_vouchers[$checkoutModel->getFreeshipVoucherId()] = [
                    'type' => $freeshipVoucher->voucher_type->code,
                    'amount' => $freeship_discount_amount,
                    'customer_id' => $customer->id
                ];
            }
            $order->vouchers()->attach($attach_vouchers);
            $subtotal = $order->inventories()->sum('order_items.total');
            $order->update([
                'total' => $order_total + $order->shipping_fee - $rank_discount - $combo_discount,
                'subtotal' => $subtotal,
                'origin_subtotal' => $order->inventories()->sum(DB::raw('order_items.origin_price * order_items.quantity')),
                'rank_discount_value' => $rank_discount,
                'combo_discount' => $combo_discount
            ]);
            $order->shipping_order()->create([
                'shipping_service_id' => $checkoutModel->getShippingServiceId(),
                'to_address' => $checkoutModel->getAddress()->full_address,
                'shipping_service_code' => $checkoutModel->getServiceId(),
                "order_value" => $order->subtotal,
                'pickup_address_id' => Config::first()->pickup_address->id,
                "cod_amount" => $order->subtotal,
                "total_fee" => $checkoutModel->getShippingFee(),
                'ship_at_office_hour' => 0
            ]);
            $order->payment()->create([
                'customer_id' => $customer->id,
                'payment_method_id' => $checkoutModel->getPaymentMethodId(),
                'amount' => $order->total,
                'order_number' => $order->order_number,
                'payment_status' => PaymentStatus::PENDING
            ]);
            $checkoutModel->getCart()->inventories()->detach($checkoutModel->getInventories()->pluck('id')->toArray());
            $redirectUrl = PaymentService::checkout($order);
            self::saveOrderToSession($order);
            event(new OrderCreatedEvent($order));
            event(new KiotOrderCreatedEvent($order));
            DB::commit();
            removeSessionCart();
            return [
                'error' => false,
                'redirectUrl' => $redirectUrl
            ];
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            $error =  "";
            if ($th->getCode() == 409) {
                $error = $th->getMessage();
            } else {
                $error = 'Đã có lỗi xảy ra, vui lòng liên hệ bộ phận chăm sóc khách hàng để nhận hỗ trợ.';
            }
            return [
                'error' => true,
                'message' => $error
            ];
        }
    }

    public static function saveOrderToSession($order) {
        $orders = session()->has('orders') ? unserialize(session()->get('orders')) : new Collection();
        $orders->push($order);
        session()->put('orders', serialize($orders));
    }
}
