<?php

namespace App\Http\Livewire\Client;

use App\Models\Banner;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BannerSliderComponent extends Component
{
    public $banners;

    public function mount() {
        $this->banners = Cache::remember('banners', env('CACHE_EXPIRE', 600), function() {
            return Banner::active()->with('image', 'phoneImage')->orderBy('order', 'desc')->orderBy('updated_at', 'desc')->get();
        });
    }
    public function render()
    {
        return view('livewire.client.banner-slider-component');
    }
}
