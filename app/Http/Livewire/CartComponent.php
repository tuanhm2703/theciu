<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CartComponent extends Component {
    public $cart;
    protected $listeners = ['cart:itemDeleted' => 'deleteInventory', 'cart:refreshComponent' => 'refresh'];

    public function mount() {
        $this->cart =  Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
    }

    public function render() {
        return view('livewire.cart-component');
    }

    public function deleteInventory(Inventory $inventory) {
        $this->cart->inventories()->detach($inventory->id);
    }

    public function refresh() {
        $this->cart = Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
    }
}
