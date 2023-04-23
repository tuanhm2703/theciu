<?php

namespace App\Http\Services\Checkout;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Events\Kiot\OrderCreatedEvent as KiotOrderCreatedEvent;
use App\Events\OrderCreatedEvent;
use App\Exceptions\InventoryOutOfStockException;
use App\Http\Services\Payment\PaymentService;
use App\Models\Config;
use App\Models\VoucherType;
use Exception;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public static function checkout(CheckoutModel $checkoutModel)
    {
        DB::beginTransaction();
        $customer = auth('customer')->user();
        try {
            $order = $customer->orders()->create([
                'total' => 0,
                'subtotal' => 0,
                'origin_subtotal' => 0,
                'shipping_fee' => $checkoutModel->getShippingFee(),
                'order_status' => OrderStatus::WAIT_TO_ACCEPT,
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
            foreach ($checkoutModel->getInventories() as $inventory) {
                $order->inventories()->attach([
                    $inventory->id => [
                        'product_id' => $inventory->product_id,
                        'quantity' => $inventory->pivot->quantity,
                        'origin_price' => $inventory->price,
                        'promotion_price' => $inventory->sale_price,
                        'total' => $inventory->sale_price * $inventory->pivot->quantity,
                        'title' => $inventory->title,
                        'name' => $inventory->name,
                        'is_reorder' => $inventory->product->is_reorder && $inventory->stock_quantity  - $inventory->pivot->quantity < 0
                    ]
                ]);
                if ($inventory->stock_quantity  - $inventory->pivot->quantity < 0 && $inventory->product->is_reorder == 0)
                    throw new InventoryOutOfStockException("Sản phẩm $inventory->name không đủ số lượng", 409);
                /* If product is not reorderable or product is reorderable and stock quantity is less
                than 0, then update stock quantity. */
            }
            $order_total = $order->inventories()->sum('order_items.total');
            $rank_discount = $customer->calculateRankDiscountAmount($order_total);
            $attach_vouchers = [];
            $order_discount_amount = 0;
            $freeship_discount_amount = 0;
            if ($checkoutModel->getOrderVoucher()) {
                $order_discount_amount = $checkoutModel->getOrderVoucher()->getDiscountAmount($order_total - $rank_discount);
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
                'total' => $order_total + $order->shipping_fee - $rank_discount,
                'subtotal' => $subtotal,
                'origin_subtotal' => $order->inventories()->sum(DB::raw('order_items.origin_price * order_items.quantity')),
                'rank_discount_value' => $rank_discount
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
            DB::commit();
            event(new OrderCreatedEvent($order));
            event(new KiotOrderCreatedEvent($order));
            return $redirectUrl;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }
}
