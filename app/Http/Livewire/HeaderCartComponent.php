<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HeaderCartComponent extends Component {
    public $cart = null;

    public $inventories;

    public $deletedInventory;

    protected $listeners = ['cart:itemDeleted' => 'deleteInventory', 'cart:itemAdded' => 'addInventory'];

    public function mount() {
        if (auth('customer')->check()) {
            $this->cart =  Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => auth('customer')->user()->id
            ]);
            $this->inventories = $this->cart->inventories;
        }
    }

    public function addInventory(Inventory $inventory, $quantity = null) {
        $customer = auth('customer')->user();
        if ($this->cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
            $this->cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : DB::raw("cart_items.quantity + 1")]], false);
        } else {
            $this->cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : 1, 'customer_id' => $customer->id]], false);
        }
        $this->inventories = $this->cart->inventories()->with('image:path,imageable_id', 'product:id,slug,name')->get();
        $this->cart->inventories = $this->inventories;
        $this->emit('cart:refreshComponent');
    }

    public function deleteInventory(Inventory $inventory) {
        $this->cart->inventories()->detach($inventory->id);
        $this->inventories = $this->cart->inventories()->with('image:path,imageable_id', 'product:id,slug,name')->get();
        $this->cart->inventories = $this->inventories;
        $this->emit('cart:refreshComponent');
    }

    public function render() {
        return view('livewire.header-cart-component');
    }
}
