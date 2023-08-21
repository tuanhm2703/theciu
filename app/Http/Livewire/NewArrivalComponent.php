<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Traits\Common\LazyloadLivewire;
use App\Traits\Common\ProductPagingComponent;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class NewArrivalComponent extends Component {
    use ProductPagingComponent, LazyloadLivewire;

    public function render() {
        return view('livewire.new-arrival-component');
    }
    public function mount() {
        $this->products = Cache::remember("new-arrival-$this->page-$this->pageSize", 600, function () {
            return Product::newArrival()->withNeededProductCardData()->getPage($this->page, $this->pageSize)->get();
        });
        $this->hasNext = $this->products->count() < Product::newArrival()->count();
    }
    public function loadMore() {
        $this->page++;
        $products = Cache::remember("new-arrival-$this->page-$this->pageSize", 600, function () {
            return Product::newArrival()->withNeededProductCardData()->getPage($this->page, $this->pageSize)->get();
        });
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < Product::newArrival()->count();
    }
}
