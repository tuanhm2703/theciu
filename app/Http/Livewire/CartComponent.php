<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartComponent extends Component {
    public function render() {
        $cart = auth('customer')->check() ? auth('customer')->user()->cart : null;
        return view('livewire.cart-component', compact('cart'));
    }
}
