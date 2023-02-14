<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use Livewire\Component;

class WishlistPage extends Component
{
    public $hasNext;

    public $page;

    public $pageSize = 8;

    public $products;

    public function mount() {
        $this->page = 1;
        $this->products = Product::whereHas('wishlists', function($q) {
            $q->where('customer_id', customer()->id);
        })->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->hasNext = $this->products->count() < Product::whereHas('wishlists', function($q) {
            $q->where('customer_id', customer()->id);
        })->count();
    }

    public function render() {
        return view('livewire.client.wishlist-page');
    }

    public function nextPage() {
        $this->page++;
        $products = Product::whereHas('wishlists', function($q) {
            $q->where('customer_id', customer()->id);
        })->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::whereHas('wishlists', function($q) {
            $q->where('customer_id', customer()->id);
        })->count();
    }
}
