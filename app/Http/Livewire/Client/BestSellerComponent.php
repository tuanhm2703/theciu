<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use App\Traits\Common\ProductPagingComponent;
use Livewire\Component;

class BestSellerComponent extends Component
{
    use ProductPagingComponent;
    public function render()
    {
        return view('livewire.client.best-seller-component');
    }
    public function mount()
    {
        $this->products = Product::available()->bestSeller()
            ->with(['inventories', 'images:path,imageable_id', 'unique_attribute_inventories' => function ($q) {
                $q->with('image');
            }])
            ->withNeededProductCardData()->getPage($this->page, $this->pageSize)->get();
        $this->hasNext = $this->products->count() < Product::available()->bestSeller()->count();
    }
    public function loadMore()
    {
        $this->page++;
        $products = Product::available()->bestSeller()
            ->with(['inventories', 'images:path,imageable_id', 'unique_attribute_inventories' => function ($q) {
                $q->with('image');
            }])->select('products.id', 'products.name', 'products.slug')->getPage($this->page, $this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::available()->bestSeller()->count();
    }
}
