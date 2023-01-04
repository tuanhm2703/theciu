<?php

namespace App\Traits\Scopes;

use App\Enums\StatusType;

trait PromotionScope {
    public function scopeAvailable($q) {
        $now = now();
        return $q->where('status', StatusType::ACTIVE)
        ->whereRaw("'$now' between promotions.from and promotions.to")
        ->whereNotNull('promotions.from')->whereNotNull('promotions.to');
    }
}
