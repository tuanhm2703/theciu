<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\OrderItem;
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
            ->with([
                'firstAttribute' => function ($q) {
                    $q->addSelect('*', 'attribute_inventory.value');
                }, 'secondAttribute' => function ($q) {
                    $q->addSelect('*', 'attribute_inventory.value');
                }, 'image:imageable_id,path,id,name'
            ])->withCount('attributes')->get();
        $this->first_attributes = collect();
        $this->inventories = $this->product->inventories->toArray();
        // dd($this->product->inventories->pluck('secondAttribute')->toArray());
        foreach ($this->product->inventories as $inventory) {
            $this->first_attributes->push((object) [
                'path' => optional($inventory->image)->path_with_domain,
                'id' => $inventory->firstAttribute->id,
                'value' => $inventory->firstAttribute->encode_value,
                'origin_value' => json_encode($inventory->firstAttribute->value),
                'image_name' => optional($inventory->image)->name,
                'out_of_stock' => $this->product->inventories->where('stock_quantity', '>', '0')->where('firstAttribute.value', $inventory->firstAttribute->value)->first() ? false : true
            ]);
        }
        $this->first_attributes = $this->first_attributes->unique('path')->unique('value');
        $this->first_attribute_id = $this->first_attribute_id ?: $this->first_attributes->where('out_of_stock', false)->first()?->id;
        $this->first_attribute_value = $this->first_attribute_value ?: $this->first_attributes->where('out_of_stock', false)->first()?->value;
        $this->second_attributes = collect();
        $inventories = $this->product->inventories->where('firstAttribute.encode_value ', $this->first_attribute_value)
            ->where('secondAttribute.id', '!=', null);
        foreach ($inventories as $inventory) {
            if ($inventory->secondAttribute) {
                $inventory->secondAttribute->value = $inventory->secondAttribute->encode_value;
                $inventory->secondAttribute->origin_value = json_encode($inventory->secondAttribute->value);
                $attr = $inventory->secondAttribute->toArray();
                $attr['out_of_stock'] = $inventory->stock_quantity == 0;
                $this->second_attributes->push((object) $attr);
            }
        }
        $this->second_attributes->unique('value');
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


    public function updated($name, $value) {
    }
    public function changeSecondAttributeId($id) {
        $this->second_attribute_id = $id;
        $this->quantity = 1;
    }
    public function changeSecondAttributeValue($value) {
        $this->second_attribute_value = $value;
        $this->reloadProductInfo();
    }

    public function changeFirstAttributeValue($value) {
        $this->first_attribute_value = $value;
        $this->second_attribute_value = null;
        $this->reloadProductInfo();
    }

    private function getInventory() {
        $this->inventory = $this->product->inventories->where('firstAttribute.encode_value', $this->first_attribute_value)->where('secondAttribute.encode_value', $this->second_attribute_value)->first();
        // dd($this->product->inventories->pluck('secondAttribute')->toArray());
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

    public function changeProduct(Product $product) {
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
        if ($this->inventory) {
            $this->addInventory($this->inventory);
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
    private function addInventory(Inventory $inventory, $quantity = null) {
        $customer = customer();
        if (!$customer) {
            $this->addInventorySession($inventory, $quantity ?? 1);
        } else {
            $cart = Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => auth('customer')->user()->id
            ]);
            if ($cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
                $cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : DB::raw("cart_items.quantity + 1")]], false);
            } else {
                $cart->inventories()->sync([$inventory->id => ['quantity' => $quantity ? $quantity : 1, 'customer_id' => $customer->id]], false);
            }
        }
    }
    private function addInventorySession(Inventory $inventory, $quantity) {
        if (session()->has('cart')) {
            $cart = unserialize(session()->get('cart'));
        } else {
            $cart = new Cart();
        }
        $i = $cart->inventories->where('id', $inventory->id)->first();
        if ($i) {
            $i->order_item->quantity += $quantity;
            $cart->inventories = $cart->inventories->filter(function (Inventory $inven) use ($i) {
                return $inven->id != $i->id;
            });
            $cart->inventories->put($inventory->id, $i);
        } else {
            $i = $inventory;
            $i->order_item = new OrderItem([
                'quantity' => $quantity,
            ]);
            $cart->inventories->push($i);
        }
        session()->put('cart', serialize($cart));
    }
}
