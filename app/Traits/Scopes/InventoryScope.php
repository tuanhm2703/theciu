<?php

namespace App\Traits\Scopes;

use Carbon\Carbon;

trait InventoryScope {
    public function scopeHavePromotion($q) {
        $now = now();
        return $q->whereHas('promotions', function($q) use ($now) {
            return $q->whereNotNull('from')->whereNotNull('to')->whereRaw("'$now' between from and to");
        });
    }
    public function scopeDontHavePromotion($q) {
        $now = now();
        return $q->whereDoesntHave('promotions', function($q) use ($now) {
            return $q->whereNotNull('promotions.from')->whereNotNull('promotions.to')->whereRaw("'$now' between promotions.from and promotions.to");
        });
    }

    public function scopeIsGoingToHavePromotion($q) {
        $now = now();
        return $q->whereNotNull('from')->whereNotNull('to')->whereRaw("'$now' > from and to > from");
    }

    public function scopeHaveStock($q) {
        return $q->where('stock_quantity', '>', 0);
    }

    public function scopeAvailable($q) {
        return $q->active()->where('stock_quantity', '>', 0);
    }

    public function scopeWithProductCheckoutInfo($q) {
        return $q->with('product:id,name,slug,status', 'product.available_promotion');
    }

    public function scopeHasAvailableProduct($q) {
        return $q->whereHas('available_product');
    }
}
