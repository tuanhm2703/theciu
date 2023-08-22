<?php

namespace App\Http\Livewire\Client;

use App\Models\Banner;
use App\Traits\Common\LazyloadLivewire;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PopupBannerComponent extends Component
{
    use LazyloadLivewire;
    public $popups;
    public function preventReload() {
        session()->put('popup-banner-show', true);
    }
    public function loadPopups() {
        if(!session()->has('popup-banner-show')) {
            $this->popups = Cache::remember('popups', env('CACHE_EXPIRE', 600), function() {
                return Banner::popup()->active()->with('desktopImage', 'phoneImage')->orderBy('order')->orderBy('updated_at', 'desc')->get();
            });
            session()->save();
            $this->emit('initPlugin', [
                'popups' => $this->popups
            ]);
            $this->readyToLoad = true;
        } else {
            $this->popups = [];
        }
        return;
    }
    public function render()
    {
        return view('livewire.client.popup-banner-component');
    }
}
