<?php

namespace App\View\Components\Client;

use App\Models\Banner;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class PopupBannerComponent extends Component
{
    public $popups;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function mount() {
        $this->popups = Cache::remember('popups', env('CACHE_EXPIRE', 600), function() {
            return Banner::popup()->active()->with('image')->orderBy('order')->orderBy('updated_at', 'desc')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.client.popup-banner-component');
    }
}
