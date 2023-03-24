<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class ProductCardComponent extends Component {

    public $product;

    public $inventory_images;

    public function render() {
        return view('livewire.client.product-card-component');
    }

    public function mount() {
        $this->inventory_images = collect();
        foreach ($this->product->inventories->where('image', '!=', null) as $inventory) {
            $this->inventory_images->push($inventory->image);
        }
        $this->inventory_images->unique('name');
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

    public function addToCart() {
        $this->emit('changeProduct', $this->product->id);
    }
}
