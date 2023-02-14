<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use Livewire\Component;

class SaleOffPage extends Component {
    public $hasNext;

    public $page;

    public $pageSize = 8;

    public $products;

    public function mount() {
        $this->page = 1;
        $this->products = Product::hasAvailablePromotions()->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->hasNext = $this->products->count() < Product::hasAvailablePromotions()->count();
    }

    public function render() {
        return view('livewire.client.sale-off-page');
    }

    public function nextPage() {
        $this->page++;
        $products = Product::hasAvailablePromotions()->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::hasAvailablePromotions()->count();
    }
}
