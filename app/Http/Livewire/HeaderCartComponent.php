<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\OrderItem;
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
            $this->cart = Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => auth('customer')->user()->id
            ]);
        } else {
            if (session()->has('cart')) {
                $this->cart = unserialize(session()->get('cart'));
            } else {
                $this->cart = new Cart();
            }
        }
        $this->readyToLoad = true;
    }

    public function addInventory(Inventory $inventory, $quantity = null) {
        if (!customer()) {
            $this->addInventorySession($inventory, $quantity);
        } else {
            $customer = auth('customer')->user();
            if ($this->cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
                $this->cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : DB::raw("cart_items.quantity + 1")]], false);
            } else {
                $this->cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : 1, 'customer_id' => $customer->id]], false);
            }
        }
        // $this->emit('cart:refresh');
        $this->dispatchBrowserEvent('openToast', [
            'message' => 'Thêm vào giỏ hàng thành công',
            'type' => 'success'
        ]);
    }
    private function addInventorySession(Inventory $inventory, $quantity) {
        if (session()->has('cart')) {
            $this->cart = unserialize(session()->get('cart'));
        } else {
            $this->cart = new Cart();
        }
        $i = $this->cart->inventories->where('id', $inventory->id)->first();
        if ($i) {
            $i->order_item->quantity += $quantity;
            $this->cart->inventories = $this->cart->inventories->filter(function (Inventory $inven) use ($i) {
                return $inven->id != $i->id;
            });
            $this->cart->inventories->put($inventory->id, $i);
        } else {
            $i = $inventory;
            $i->order_item = new OrderItem([
                'quantity' => $quantity,
            ]);
            $this->cart->inventories->push($i);
        }
        session()->put('cart', serialize($this->cart));
    }
    public function deleteInventory(Inventory $inventory) {
        if (customer()) {
            $this->cart->inventories()->detach($inventory->id);
            $this->cart =  Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => auth('customer')->user()->id
            ]);
            $this->emit('cart:refresh');
        } else {
            $this->cart = unserialize(session()->get('cart'));
            $this->cart->inventories = $this->cart->inventories->filter(function (Inventory $inven) use ($inventory) {
                return $inven->id !== $inventory->id;
            });
            session()->put('cart', serialize($this->cart));
        }
    }

    public function render() {
        return view('livewire.header-cart-component');
    }

    public function goToCart() {
        if (customer()) return route('client.auth.cart.index');
        $this->dispatchBrowserEvent('openLoginForm');
    }
}
