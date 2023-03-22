<?php

namespace App\Http\Livewire;

use App\Models\Inventory;
use App\Models\Product;
use Livewire\Component;

class ProductPickItemComponent extends Component
{
    public Product $product;
    public $first_attribute_value = null;
    public $second_attribute_value;
    public $first_attribute_id = null;
    public $second_attribute_id;
    public $second_attributes = [];
    public $first_attributes = [];

    protected $listeners = ['product-pick:changeProduct' => 'changeProduct'];

    public function mount()
    {
        $this->reloadProductInfo();
    }

    private function reloadProductInfo()
    {
        $this->product->setRelation('inventories', $this->product->inventories()
            ->with(['attributes', 'firstAttribute' => function ($q) {
                $q->addSelect('*', 'attribute_inventory.value');
            }, 'secondAttribute' => function($q) {
                $q->addSelect('*', 'attribute_inventory.value');
            }, 'image:imageable_id,path,id,name'])->withCount('attributes')->get());
        $this->first_attributes = collect();
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
        $this->first_attribute_id = $this->first_attribute_id ?? $this->first_attributes->where('out_of_stock', false)->first()->id;
        $this->first_attribute_value = $this->first_attribute_value ?? $this->first_attributes->where('out_of_stock', false)->first()->value;
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
    }

    public function render()
    {
        return view('livewire.product-pick-item-component');
    }
    public function changeFirstAttributeId($attribute_id)
    {
        $this->first_attribute_id = $attribute_id;
        $this->reloadProductInfo();
    }

    public function addToCart()
    {
        $inventory = $this->product->inventories()->whereHas('attributes', function ($q) {
            $q->where('attributes.id', $this->first_attribute_id)->where('attribute_inventory.value', $this->first_attribute_value);
        });
        if (count($this->second_attributes) > 0) {
            $inventory->whereHas('attributes', function ($q) {
                $q->where('attributes.id', $this->second_attribute_id)->where('attribute_inventory.value', $this->second_attribute_value);
            });
        }
        $inventory = $inventory->first();
        $this->emit('cart:itemAdded', $inventory->id);
    }

    public function changeSecondAttributeId($id)
    {
        $this->second_attribute_id = $id;
    }

    public function addToWishlist()
    {
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

    public function changeProduct(Product $product)
    {
        $this->product = $product;
        $this->first_attribute_id = null;
        $this->first_attribute_value = null;
        $this->reloadProductInfo();
        $this->dispatchBrowserEvent('openQuickPreview');
    }
}
