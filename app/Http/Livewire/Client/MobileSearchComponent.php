<?php

namespace App\Http\Livewire\Client;

use App\Enums\KeywordCount;
use App\Models\Product;
use Livewire\Component;

class MobileSearchComponent extends Component
{
    use KeywordCount;

    public $search_products = [];
    public function render()
    {
        return view('livewire.client.mobile-search-component');
    }
    public function searchProducts() {
        $this->search_products = Product::available()->search('name', $this->keyword)->limit(15)->get();
    }

    public function updated($name, $value)
    {
        if ($name == 'keyword') {
            $this->searchProducts();
        }
    }
}