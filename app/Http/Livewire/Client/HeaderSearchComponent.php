<?php

namespace App\Http\Livewire\Client;

use App\Enums\KeywordCount;
use App\Models\Product;
use Livewire\Component;

class HeaderSearchComponent extends Component
{
    use KeywordCount;

    public $search_products = [];

    public function render()
    {
        return view('livewire.client.header-search-component');
    }

    public function searchProducts() {
        $this->search_products = Product::available()->search('name', $this->keyword)->limit(15)->get();
    }

    public function updated($name, $value)
    {
        if ($name == 'keyword') {
            $this->keyword = preg_replace('/[^A-Za-z0-9 \/]/', '', $this->keyword);
            $this->searchProducts();
        }
    }

}
