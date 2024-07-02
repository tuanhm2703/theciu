<?php

namespace App\Http\Services\Cart;

use App\Exceptions\Api\ApiException;
use App\Exceptions\Api\InventoryOutOfStockException;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\GetShippingInfoRequest;
use App\Http\Services\Checkout\CheckoutModel;
use App\Http\Services\Checkout\CheckoutService;
use App\Http\Services\Logger\CheckoutLogger;
use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\Shipping\Models\DeliveryData;
use App\Http\Services\Shipping\Models\PackageInfo;
use App\Http\Services\Voucher\VoucherService;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Promotion;
use App\Models\ShippingService;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartService {
    private Customer $user;
    public function __construct(private GHTKService $shipping_service, private VoucherService $voucherService, private CheckoutService $checkoutService, private CheckoutLogger $logger) {
    }

    public function setUser(Customer $user) {
        $this->user = $user;
        return $this;
    }

    public function getCartWithInventories(): Cart {
        return Cart::with(['inventories', 'inventories.image', 'inventories.product:id,slug,name'])->firstOrCreate([
            'customer_id' => $this->user->id
        ]);
    }

    public function getCart(): Cart {
        return Cart::firstOrCreate([
            'customer_id' => $this->user->id
        ]);
    }

    public function addToCart(int $quantity, int $inventory_id): void {
        $inventory = Inventory::find($inventory_id);
        $cart = $this->getCart();
        if ($inventory->isOutOfStock() || $this->isNotEnoughStock($inventory, $quantity)) {
            throw new InventoryOutOfStockException($inventory);
        }
        $cart->inventories()->sync([
            $inventory->id => [
                'quantity' => $quantity,
                'customer_id' => $this->user->id
            ]
        ], false);
    }

    public function removeFromCart(Inventory $inventory): void {
        $cart = $this->getCart();
        $cart->inventories()->detach([$inventory->id]);
    }

    private function isNotEnoughStock(Inventory $inventory, int $quantity): bool {
        return $inventory->stock_quantity < $quantity;
    }


    public function getShippingInfo(GetShippingInfoRequest $request): array {
        $shipping_service_types = $this->shipping_service->getShipServices();
        $data = $request->validated();
        $total = $data['total'] ?? null;
        $ward_id = $data['ward_id'] ?? null;
        $detail_address = $data['detail_address'] ?? null;
        $inventory_ids = $data['inventory_ids'] ?? null;
        foreach ($shipping_service_types as $shipping_service_type) {
            $data = $this->calculateShippingInfo($shipping_service_type, $inventory_ids, $ward_id, $total, $detail_address);
            $shipping_service_type->fee = $data['fee'];
            $shipping_service_type->delivery_date = $data['date'];
            $shipping_service_type->delivery_date = now()->diffInDays($data['default_format_date']) <= 1 ? now()->addDays(2 - now()->diffInDays($data['default_format_date'])) : $data['default_format_date'];
            $shipping_service_type->delivery_date = $shipping_service_type->delivery_date->clone()->format('d/m') . " - " . $shipping_service_type->delivery_date->clone()->addDays(2)->format('d/m');
        }
        return $shipping_service_types;
    }

    public function calculateShippingFee(string $shipping_service_id, array $inventory_ids, int $total, Address $address) {
        $shipping_service_type = collect($this->shipping_service->getShipServices())->where('service_id', $shipping_service_id)->first();
        if (!$shipping_service_type) {
            throw new ApiException("Phương thức vận chuyển không hợp lệ");
        }
        $data = $this->calculateShippingInfo($shipping_service_type, $inventory_ids, $address->ward_id, $total, $address->details);
        return $data['fee'];
    }

    private function calculateShippingInfo($shipping_service_type, array $inventory_ids, int $ward_id, int $total, string $detail_address) {
        $shipping_service_type = (object) $shipping_service_type;
        $package_info = $this->getPackageInfo($inventory_ids);
        $address = new Address();
        $ward = Ward::find($ward_id);
        $address->province_id = $ward->district->province->id;
        $address->district_id = $ward->district->id;
        $address->details = $detail_address;
        $deliveryData = new DeliveryData(
            $address,
            $shipping_service_type->service_id,
            $shipping_service_type->service_type_id,
            $total,
            $package_info->weight,
            $package_info->length,
            $package_info->width,
            $package_info->height
        );
        $fee = $this->shipping_service->calculateDeliveryFee($deliveryData)->total;
        $date = $this->shipping_service->calculateDeliveryTime($deliveryData);
        return [
            'fee' => $fee,
            'date' => $date->clone()->format('d-m-Y'),
            'default_format_date' => $date
        ];
    }

    public function getPackageInfo(array $inventory_ids): PackageInfo {
        $inventories = Inventory::whereIn('id', $inventory_ids)->get();
        $package_info = new PackageInfo(0, 0, 0, 0);
        foreach ($inventories as $inventory) {
            $package_info->height += $inventory->package_info->height * $inventory->cart_stock;
            $package_info->weight += $inventory->package_info->weight * $inventory->cart_stock;
            $package_info->length = $inventory->package_info->length;
            $package_info->width = $inventory->package_info->width;
        }
        return $package_info;
    }

    private function verifyAccomGiftPromotion(Promotion|int $promotion, Collection $gift_inventories, int $total) {
        if (is_int($promotion)) {
            $promotion = Promotion::find($promotion);
        }
        if (!$promotion) {
            throw new ApiException("Chương trình áp dụng không hợp lệ");
        }
        if ($total < $promotion->min_order_value) {
            throw new ApiException("Đơn hàng chưa đủ giá trị tối thiểu để áp dụng chương trình $promotion->name");
        }
        foreach ($gift_inventories as $inventory) {
            if (!$inventory->product?->available_promotion || ($inventory->product->available_promotion && $inventory->product->available_promotion->id !== $promotion->id)) {
                throw new ApiException("Chương trình áp dụng không hợp lệ");
            }
        }
    }

    private function verifyAccomProductPromotion(Promotion|int $promotion, Collection $gift_inventories, Collection $inventories) {
        if (is_int($promotion)) {
            $promotion = Promotion::find($promotion);
        }
        if (!$promotion) {
            throw new ApiException("Chương trình áp dụng không hợp lệ");
        }
        if ($promotion->num_of_products < $gift_inventories->count()) {
            throw new ApiException("Số lượng sản phẩm dược tăng kèm không hợp lệ");
        }
        foreach ($gift_inventories as $inventory) {
            if (!$inventory->product?->available_promotion || ($inventory->product->available_promotion && $inventory->product->available_promotion->id !== $promotion->id)) {
                throw new ApiException("Chương trình áp dụng không hợp lệ");
            }
            if ($inventory->product->is_main_product) {
                throw new ApiException("Sản phẩm " . $inventory->product->name . " không phải sản phẩm tặng kèm");
            }
        }
    }

    public function checkout(CheckoutRequest $request) {
        DB::beginTransaction();
        try {
            $inventories = Inventory::whereIn('id', $request->inventory_ids)->withProductCheckoutInfo()->get();
            $customer = requestUser();
            $cart = $customer->cart;
            $total = $cart->getTotalWithSelectedItems($request->inventory_ids);
            $address = $customer->addresses()->find($request->address_id);
            $accom_gift_inventories = new Collection;
            if ($request->accom_gift_promotion) {
                $accom_gift_inventories = Inventory::whereIn('id', $request->accom_gift_promotion['inventory_ids'])->withProductCheckoutInfo()->get();
                $this->verifyAccomGiftPromotion($request->accom_gift_promotion['id'], $accom_gift_inventories, $total);
            }
            if ($request->accom_product_promotion) {
                $accom_product_inventories = Inventory::whereIn('id', $request->accom_product_promotion['inventory_ids'])->withProductCheckoutInfo()->get();
                $this->verifyAccomProductPromotion($request->accom_product_promotion['id'], $accom_product_inventories, $inventories);
            }
            if ($request->order_voucher_id && !$this->voucherService->verifyVoucher($request->order_voucher_id, $customer, $total)) {
                throw new ApiException("Voucher giảm giá đơn hàng không hợp lệ");
            }
            if ($request->freeship_voucher_id && !$this->voucherService->verifyVoucher($request->freeship_voucher_id, $customer, $total)) {
                throw new ApiException("Voucher giảm giá vận chuyển không hợp lệ");
            }

            $checkoutModel = new CheckoutModel([
                'address' => $address,
                'cart' => $cart,
                'shipping_fee' => $this->calculateShippingFee($request->shipping_service_id, $request->inventory_ids, $cart->getTotalWithSelectedItems($request->inventory_ids), $address),
                'payment_method_id' => $request->payment_method_id,
                'shipping_service_id' => ShippingService::first()->id,
                'service_id' => $request->shipping_service_id,
                'item_selected' => $request->inventory_ids,
                'order_voucher_id' => $request->order_voucher_id,
                'freeship_voucher_id' => $request->freeship_voucher_id,
                'note' => $request->note,
                'customer' => $customer,
                'accom_inventories' => $request->accom_gift_promotion ? Inventory::whereIn('id', $request->accom_gift_promotion['inventory_ids'])->get() : new Collection(),
                'accom_product_inventories' => $request->accom_production_promotion ? Inventory::whereIn('id', $request->accom_product_promotion['inventory_ids'])->get() : new Collection(),
                'additional_discount' => $request->additional_discount
            ]);
            $redirectUrl = $this->checkoutService->checkoutV2($checkoutModel);
            DB::commit();
            return $redirectUrl;
        } catch (ApiException $e) {
            $this->logger->error($e);
            throw $e;
        } catch(InventoryOutOfStockException $e) {
            $this->logger->error($e);
            throw $e;
        } catch(Throwable $e) {
            $this->logger->error($e);
            throw new ApiException('Đã có lỗi xảy ra vui lòng thử lại');
        }
    }
}
