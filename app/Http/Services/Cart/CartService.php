<?php

namespace App\Http\Services\Cart;

use App\Exceptions\Api\InventoryOutOfStockException;
use App\Http\Requests\Api\AddToCartRequest;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class CartService {
    private Customer $user;

    public function __construct() {
    }

    public function setUser(Customer $user) {
        $this->user = $user;
        return $this;
    }

    public function getCartWithInventories(): Cart {
        return Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => $this->user->id
        ]);
    }

    public function getCart(): Cart {
        return Cart::firstOrCreate([
            'customer_id' => $this->user->id
        ]);
    }

    public function addToCart(AddToCartRequest $request): void {
        $quantity = $request->quantity ?? 1;
        $inventory = Inventory::find($request->inventory_id);
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
}
