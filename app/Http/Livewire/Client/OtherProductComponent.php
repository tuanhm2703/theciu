<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use Livewire\Component;

class OtherProductComponent extends Component {
    public $hasNext;

    public $page;

    public $pageSize = 4;

    public $product;

    public $products;

    public function mount() {
        $this->page = 1;
        $this->products = Product::where('id', '!=', $this->product->id)
            ->with(['category', 'inventories' => function ($q) {
                return $q->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])
            ->whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->product->categories->pluck('id')->toArray());
            })->orderBy('created_at', 'desc')->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->hasNext = $this->products->count() < Product::where('id', '!=', $this->product->id)
            ->with(['category', 'inventories' => function ($q) {
                return $q->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])
            ->whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->product->categories->pluck('id')->toArray());
            })->count();
    }

    public function render() {
        return view('livewire.client.other-product-component');
    }

    public function nextPage() {
        $this->page++;
        $products = Product::where('id', '!=', $this->product->id)
            ->with(['category', 'inventories' => function ($q) {
                return $q->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])
            ->whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->product->categories->pluck('id')->toArray());
            })->orderBy('created_at', 'desc')->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::where('id', '!=', $this->product->id)
        ->with(['category', 'inventories' => function ($q) {
            return $q->with(['image', 'attributes' => function ($q) {
                $q->orderBy('attribute_inventory.created_at', 'desc');
            }]);
        }])
        ->whereHas('categories', function ($q) {
            $q->whereIn('categories.id', $this->product->categories->pluck('id')->toArray());
        })->count();
    }
}
