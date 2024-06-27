<?php

namespace App\Http\Services\Cart;

use App\Exceptions\Api\InventoryOutOfStockException;
use App\Http\Requests\Api\AddToCartRequest;
use App\Http\Requests\Api\GetShippingInfoRequest;
use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\Shipping\Models\DeliveryData;
use App\Http\Services\Shipping\Models\PackageInfo;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;

class CartService {
    private Customer $user;

    public function __construct(private GHTKService $shipping_service) {
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
}
