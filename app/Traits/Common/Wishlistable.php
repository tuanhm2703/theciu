<?php

namespace App\Traits\Common;

use App\Models\Wishlist;

trait Wishlistable {
    public function addToWishlist($wishlistable) {
        return $this->wishlists()->create($wishlistable);
    }

    public function removeFromCustomerWishlist($customer_id) {
        return $this->wishlists()->where('customer_id', $customer_id)->delete();
    }

    public function wishlists() {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }
}
