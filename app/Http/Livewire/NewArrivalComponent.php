<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class NewArrivalComponent extends Component {
    public $products;

    public $hasNext;

    public $page = 1;

    public $pageSize = 8;

    public function mount() {
        $this->products = Product::available()->newArrival()
            ->with('inventories', 'images:path,imageable_id')
            ->select('products.id', 'products.name', 'products.slug')->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->hasNext = $this->products->count() < Product::available()->newArrival()->count();
    }

    public function render() {
        return view('livewire.new-arrival-component');
    }

    public function loadMore() {
        $this->page++;
        $products = Product::available()->newArrival()
            ->with('inventories', 'images:path,imageable_id')
            ->select('products.id', 'products.name', 'products.slug')->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::available()->newArrival()->count();
    }
}
