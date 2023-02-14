<?php

namespace App\Traits\Scopes;

trait ProductScope {
    public function scopeFindBySlug($q, $slug) {
        return $q->where('products.slug', $slug);
    }

    public function scopeDontHavePromotion($q) {
        $now = now();
        return $q->whereDoesntHave('promotions', function ($q) use ($now) {
            return $q->whereNotNull('promotions.from')->whereNotNull('promotions.to')->where(function ($q) use ($now) {
                $q->whereRaw("'$now' between promotions.from and promotions.to")->orWhere('promotions.from', '>=', now());
            });
        });
    }

    public function scopeNewArrival($q) {
        $dayForNewArrival = 4;
        $now = now();
        return $q->whereRaw("TIMESTAMPDIFF(DAY, updated_at, '$now') <= $dayForNewArrival");
    }

    public function scopeAvailable($q) {
        return $q->where(function ($q) {
            $q->whereHas('inventories', function ($q) {
                $q->where('stock_quantity', '>', 0);
            })->orWhere('products.is_reorder', 1);
        });
    }

    public function scopeHasAvailablePromotions($q) {
        return $q->whereHas('promotions', function ($q) {
            $q->available();
        });
    }

    public function scopeWithNeededProductCardData($q) {
        return $q->available()->with('image:path,imageable_id')->select('id', 'slug', 'name');
    }
}
