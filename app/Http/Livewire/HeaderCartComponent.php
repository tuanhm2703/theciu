<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Inventory;
use App\Traits\Common\LazyloadLivewire;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HeaderCartComponent extends Component {
    use LazyloadLivewire;
    public $cart = null;

    public $inventories;

    public $deletedInventory;

    protected $listeners = ['cart:itemDeleted' => 'deleteInventory', 'cart:itemAdded' => 'addInventory', 'cart:refresh' => '$refresh'];

    public function loadContent() {
        if (auth('customer')->check()) {
            $this->cart =  Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => auth('customer')->user()->id
            ]);
        }
        $this->readyToLoad = true;
    }

    public function addInventory(Inventory $inventory, $quantity = null) {
        if(!auth('customer')->check()) {
            $this->dispatchBrowserEvent('openLoginForm');
        } else {
            $customer = auth('customer')->user();
            if ($this->cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
                $this->cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : DB::raw("cart_items.quantity + 1")]], false);
            } else {
                $this->cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : 1, 'customer_id' => $customer->id]], false);
            }
            $this->emit('cart:refresh');
        }
    }

    public function deleteInventory(Inventory $inventory) {
        $this->cart->inventories()->detach($inventory->id);
        $this->cart =  Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
        $this->emit('cart:refresh');
    }

    public function render() {
        return view('livewire.header-cart-component');
    }

    public function goToCart() {
        return route('client.auth.cart.index');
    }
}
