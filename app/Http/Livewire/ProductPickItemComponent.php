<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductPickItemComponent extends Component {
    public $product;
    public function render() {
        return view('livewire.product-pick-item-component');
    }
}
