<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DealOfDayComponent extends Component
{
    public $flash_sale_products;

    public function mount() {
        $this->flash_sale_products = Cache::remember("deal_of_day", env('CACHE_EXPIRE', 600), function() {
            return Product::whereHas('flash_sale')->withNeededProductCardData()->get();
        });
    }

    public function render()
    {
        return view('livewire.client.deal-of-day-component');
    }
}
