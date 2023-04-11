<?php

namespace App\Http\Livewire\Client;

use App\Models\Page;
use Livewire\Component;

class FooterComponent extends Component
{
    public $pages;

    public function mount() {
        $this->pages = Page::select('title', 'slug')->orderBy('order')->get();
    }
    public function render()
    {
        return view('livewire.client.footer-component');
    }
}
