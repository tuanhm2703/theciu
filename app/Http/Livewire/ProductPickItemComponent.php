<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductPickItemComponent extends Component {
    public Product $product;
    public $first_attribute_value = null;
    public $second_attribute_value;
    public $first_attribute_id = null;
    public $second_attribute_id;
    public $second_attributes = [];
    public $first_attributes = [];
    public $inventory = null;
    public $inventories = null;
    public $quantity = 1;
    public $parentId;
    public $popup = true;
    protected $listeners = ['product-pick:changeProduct' => 'changeProduct'];
    public function mount() {
        $this->reloadProductInfo();
    }

    private function reloadProductInfo() {
        $this->product->inventories = $this->product->inventories()
            ->with(['attributes', 'firstAttribute' => function ($q) {
                $q->addSelect('*', 'attribute_inventory.value');
            }, 'secondAttribute' => function ($q) {
                $q->addSelect('*', 'attribute_inventory.value');
            }, 'image:imageable_id,path,id,name'])->withCount('attributes')->get();
        $this->first_attributes = collect();
        $this->inventories = $this->product->inventories->toArray();
        foreach ($this->product->inventories as $inventory) {
            $this->first_attributes->push((object) [
                'path' => optional($inventory->image)->path_with_domain,
                'id' => $inventory->firstAttribute->id,
                'value' => $inventory->firstAttribute->value,
                'image_name' => optional($inventory->image)->name,
                'out_of_stock' => $this->product->inventories->where('stock_quantity', '>', '0')->where('firstAttribute.value', $inventory->firstAttribute->value)->first() ? false : true
            ]);
        }
        $this->first_attributes = $this->first_attributes->unique('path')->unique('value');
        $this->first_attribute_id = $this->first_attribute_id ?: $this->first_attributes->where('out_of_stock', false)->first()?->id;
        $this->first_attribute_value = $this->first_attribute_value ?: $this->first_attributes->where('out_of_stock', false)->first()?->value;
        $this->second_attributes = collect();
        $inventories = $this->product->inventories->where('firstAttribute.value', $this->first_attribute_value)
            ->where('secondAttribute.id', '!=', null);
        foreach ($inventories as $inventory) {
            if ($inventory->secondAttribute) {
                $attr = $inventory->secondAttribute->toArray();
                $attr['out_of_stock'] = $inventory->stock_quantity == 0;
                $this->second_attributes->push((object) $attr);
            }
        }
        $this->second_attributes->unique('value');
        $this->second_attribute_value = null;
        $this->getInventory();
    }

    public function render() {
        return view('livewire.product-pick-item-component');
    }
    public function changeFirstAttributeId($attribute_id) {
        $this->first_attribute_id = $attribute_id;
        $this->reloadProductInfo();
    }

    public function addToCart() {
        if ($this->inventory) {
            $this->emit('cart:itemAdded', $this->inventory?->id, $this->quantity);
        } else {
            $this->dispatchBrowserEvent('openToast', [
                'type' => 'error',
                'message' => 'Vui lòng chọn thuộc tính sản phẩm'
            ]);
        }
    }

    public function changeSecondAttributeId($id) {
        $this->second_attribute_id = $id;
        $this->quantity = 1;
    }

    public function updated($name, $value) {
        if ($name === 'first_attribute_value') {
            $this->reloadProductInfo();
        }
        $this->getInventory();
    }

    public function changeFirstAttributeValue($value) {
        $this->first_attribute_value = json_decode($value);
        $this->reloadProductInfo();
    }

    private function getInventory() {
        $this->inventory = collect($this->inventories)->where('first_attribute.value', $this->first_attribute_value)->where('second_attribute.value', $this->second_attribute_value)->first();
        $this->inventory = $this->inventory ? $this->product->inventories->where('id', $this->inventory['id'])->first() : null;
    }

    public function addToWishlist() {
        if (!auth('customer')->check()) {
            $this->dispatchBrowserEvent('openLoginForm');
        } else {
            if ($this->product->is_on_customer_wishlist) {
                $this->product->removeFromCustomerWishlist(auth('customer')->user()->id);
            } else {
                $this->product->addToWishlist(['customer_id' => auth('customer')->user()->id]);
            }
            $this->product->is_on_customer_wishlist = !$this->product->is_on_customer_wishlist;
            $this->emitTo('client.header-wishlist-component', 'refresh');
        }
    }

    public function changeProduct(Product $product, $id = null) {
        if ($this->popup) {
            $this->inventory = null;
            $this->product = $product;
            $this->first_attribute_id = null;
            $this->first_attribute_value = null;
            $this->quantity = 1;
            $this->reloadProductInfo();
            $this->dispatchBrowserEvent('openQuickPreview');
        }
    }
    public function buyNow() {
        $customer = auth('customer')->user();
        if (!$customer) $this->dispatchBrowserEvent('openLoginModal');
        if ($this->inventory) {
            $cart = Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => auth('customer')->user()->id
            ]);
            if ($cart->inventories()->where('inventories.id', $this->inventory->id)->exists()) {
                $cart->inventories()->sync([$this->inventory->id => ['quantity' => DB::raw("cart_items.quantity + 1")]], false);
            } else {
                $cart->inventories()->sync([$this->inventory->id => ['quantity' => 1, 'customer_id' => $customer->id]], false);
            }
            return redirect()->route('client.auth.cart.index', [
                'item_selected' => [$this->inventory?->id]
            ]);
        } else {
            $this->dispatchBrowserEvent('openToast', [
                'type' => 'error',
                'message' => 'Vui lòng chọn thuộc tính sản phẩm'
            ]);
        }
    }
}
