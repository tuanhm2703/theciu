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
            return Product::whereHas('available_flash_sales')->whereHas('inventories', function($q) {
                $q->whereRaw('now() between inventories.promotion_from and inventories.promotion_to')->where('stock_quantity', '>', 0)->where('promotion_status', 1);
            })->withNeededProductCardData()->limit(10)->get();
        });
    }

    public function render()
    {
        return view('livewire.client.deal-of-day-component');
    }
}
