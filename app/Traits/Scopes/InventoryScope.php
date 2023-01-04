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
            return $q->whereNotNull('from')->whereNotNull('to')->whereRaw("'$now' between from and to");
        });
    }

    public function scopeIsGoingToHavePromotion($q) {
        $now = now();
        return $q->whereNotNull('from')->whereNotNull('to')->whereRaw("'$now' > from and to > from");
    }
}
