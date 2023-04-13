<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use App\Traits\Common\LazyloadLivewire;
use App\Traits\Common\ProductPagingComponent;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BestSellerComponent extends Component
{
    use ProductPagingComponent, LazyloadLivewire;
    public function render()
    {
        return view('livewire.client.best-seller-component');
    }
    public function mount()
    {
        $this->products = Cache::remember("best_seller_$this->page" . "_$this->pageSize", env('CACHE_EXPIRE', 600), function () {
            return Product::available()->bestSeller()
                ->with(['inventories', 'images:path,imageable_id', 'unique_attribute_inventories' => function ($q) {
                    $q->with('image');
                }])
                ->withNeededProductCardData()->getPage($this->page, $this->pageSize)->get();
        });
        $this->hasNext = $this->products->count() < Product::available()->bestSeller()->count();
    }
    public function loadMore()
    {
        $this->page++;
        $products = Cache::remember("best_seller_$this->page" . "_$this->pageSize", env('CACHE_EXPIRE', 600), function () {
            return Product::available()->bestSeller()
                ->with(['inventories', 'images:path,imageable_id', 'unique_attribute_inventories' => function ($q) {
                    $q->with('image');
                }])->select('products.id', 'products.name', 'products.slug')->getPage($this->page, $this->pageSize)->get();
        });
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::available()->bestSeller()->count();
    }
}
