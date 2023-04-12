<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Traits\Common\LazyloadLivewire;
use App\Traits\Common\ProductPagingComponent;
use Livewire\Component;

class NewArrivalComponent extends Component {
    use ProductPagingComponent, LazyloadLivewire;

    public function render() {
        return view('livewire.new-arrival-component');
    }
    public function mount() {
        $this->products = Product::newArrival()->withNeededProductCardData()->getPage($this->page, $this->pageSize)->get();
        $this->hasNext = $this->products->count() < Product::newArrival()->count();
    }
    public function loadMore() {
        $this->page++;
        $products = Product::newArrival()->withNeededProductCardData()->getPage($this->page, $this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::newArrival()->count();
    }
}
