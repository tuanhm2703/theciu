<?php

namespace App\Http\Livewire;

use App\Models\Inventory;
use App\Models\Product;
use Livewire\Component;

class ProductPickItemComponent extends Component {
    public Product $product;
    public $first_attribute_id;
    public $second_attribute_id;
    public $second_attributes = [];
    public $first_attributes = [];
    public function mount() {
        $this->product->setRelation('inventories', $this->product->inventories()
        ->with(['attributes', 'firstAttribute' => function($q) {
            $q->addSelect('*', 'attribute_inventory.value');
        }, 'secondAttribute', 'image:imageable_id,path'])->get());
        $this->first_attributes = collect();
        foreach ($this->product->inventories as $inventory) {
            $this->first_attributes->push((object) [
                'path' => $inventory->image->path_with_domain,
                'id' => $inventory->firstAttribute->id,
                'value' => $inventory->firstAttribute->value
            ]);
        }
        $this->first_attributes = $this->first_attributes->unique('path')->unique('value');


        $this->first_attribute_id = $this->first_attributes->first()->id;
        $this->second_attributes = collect();
        $inventories = $this->product->inventories()
        ->haveStock()
        ->withCount('attributes')
        ->with(['secondAttribute' => function($q) {
            return $q->addSelect('*', 'attribute_inventory.value');
        }])
        ->whereHas('attributes', function($q) {
            return $q->where('attributes.id', $this->first_attribute_id);
        })->get();
        foreach ($inventories as $inventory) {
            if($inventory->attributes_count > 1) {
                if($this->second_attributes->where('value', $inventory->secondAttribute->value)->count() == 0) {
                    $this->second_attributes->push($inventory->secondAttribute);
                }
            }
        }
        $this->second_attributes->unique('value');
    }

    public function render() {
        return view('livewire.product-pick-item-component');
    }
    public function changeFirstAttributeId($attribute_id) {
        $attribute_id;
        $this->second_attributes = collect();
        $inventories = $this->product->inventories()
        ->haveStock()
        ->withCount('attributes')
        ->with(['secondAttribute' => function($q) {
            return $q->addSelect('*', 'attribute_inventory.value');
        }])
        ->whereHas('attributes', function($q) use ($attribute_id) {
            return $q->where('attributes.id', $attribute_id);
        })->get();
        foreach ($inventories as $inventory) {
            if($inventory->attributes_count > 1) {
                if($this->second_attributes->where('value', $inventory->secondAttribute->value)->count() == 0) {
                    $this->second_attributes->push($inventory->secondAttribute);
                }
            }
        }
        $this->second_attributes->unique('value');
    }

    public function addToCart() {
        $inventory = $this->product->inventories()->whereHas('attributes', function($q) {
            $q->whereIn('attributes.id', [$this->first_attribute_id, $this->second_attribute_id]);
        })->first();
        $this->emit('cart:itemAdded', $inventory->id);
    }
}
