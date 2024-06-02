<?php

namespace App\Traits\Common;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wishlist;

trait Wishlistable {
    public function addToWishlist($customer_id) {
        $wishlisable_class = get_class($this);
        cache()->forget("wishlist:$wishlisable_class:$customer_id");
        return $this->wishlists()->create([
            'customer_id' => $customer_id
        ]);
    }

    public function removeFromCustomerWishlist($customer_id) {
        $wishlisable_class = get_class($this);
        cache()->forget("wishlist:$wishlisable_class:$customer_id");
        return $this->wishlists()->where('customer_id', $customer_id)->delete();
    }

    public function wishlists() {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }
}
