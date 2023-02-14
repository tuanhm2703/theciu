<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class HeaderWishlistComponent extends Component {
    public $number_of_wishlists = 0;

    protected $listeners = ['refresh' => 'reCount'];

    public function reCount() {
        if(checkAuthCustomer()){
            $this->number_of_wishlists = customer()->product_wishlists()->count();
        }
    }
    public function mount() {
        if(checkAuthCustomer()){
            $this->number_of_wishlists = customer()->product_wishlists()->count();
        }
    }

    public function render() {
        return view('livewire.client.header-wishlist-component');
    }

    public function redirectToWishlistPage() {
        if (!auth('customer')->check()) {
            $this->dispatchBrowserEvent('openLoginForm');
        } else {
            return redirect()->route('client.product.my_wishlist');
        }
    }
}
