<?php

namespace App\Traits\Common;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;

trait HasWishlist {
    public function product_wishlists() {
        return $this->hasMany(Wishlist::class)->where('wishlistable_type', (new Product())->getMorphClass());
    }
    public function collection_wishlist() {
        return $this->hasMany(Wishlist::class)->where('wishlistable_type', (new Category())->getMorphClass());
    }
    public function query_wishlist(string $wishlisable_type) {
        return $this->hasMany(Wishlist::class)->where('wishlistable_type', $wishlisable_type);
    }
    public function get_wishlist(string $wishlisable_type) {
        return cache()->remember("wishlist:$wishlisable_type:$this->id", 300, function () use ($wishlisable_type) {
            return $this->hasMany(Wishlist::class)->where('wishlistable_type', $wishlisable_type)->pluck('id')->toArray();
        });
    }
}
