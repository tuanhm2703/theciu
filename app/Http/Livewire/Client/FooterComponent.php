<?php

namespace App\Http\Livewire\Client;

use App\Models\Branch;
use App\Models\Page;
use App\Models\PaymentMethod;
use Livewire\Component;

class FooterComponent extends Component
{
    public $pages;
    public $payment_methods;
    public $branches;
    public function mount() {
        $this->pages = Page::select('title', 'slug')->orderBy('order')->get();
        $this->payment_methods = PaymentMethod::active()->with('image:imageable_id,path')->whereHas('image')->get();
        $this->branches = Branch::all();
    }
    public function render()
    {
        return view('livewire.client.footer-component');
    }
}
