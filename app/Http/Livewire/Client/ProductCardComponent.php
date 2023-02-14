<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class ProductCardComponent extends Component {

    public $product;

    public function render() {
        return view('livewire.client.product-card-component');
    }

    public function addToWishlist() {
        if (!auth('customer')->check()) {
            $this->dispatchBrowserEvent('openLoginForm');
        } else {
            if ($this->product->is_on_customer_wishlist) {
                $this->product->removeFromCustomerWishlist(auth('customer')->user()->id);
            } else {
                $this->product->addToWishlist(['customer_id' => auth('customer')->user()->id]);
            }
            $this->product->is_on_customer_wishlist = !$this->product->is_on_customer_wishlist;
            $this->emitTo('client.header-wishlist-component', 'refresh');
        }
    }
}
