<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductPickItemComponent extends Component {
    public Product $product;
    public function render() {
        return view('livewire.product-pick-item-component');
    }
}
