<?php

namespace App\Traits\Scopes;

use App\Enums\StatusType;

trait PromotionScope {
    public function scopeAvailable($q) {
        return $q->where('status', StatusType::ACTIVE)->happenning();
    }

    public function scopeHaveNotEnded($q) {
        return $q->where('status', StatusType::ACTIVE)->where(function($q) {
            $q->incomming()->orWhere(function($q) {
                $q->happenning();
            });
        });
    }

    public function scopeIncomming($q) {
        return $q->whereRaw("now() < promotions.from")
        ->whereNotNull('promotions.from')->whereNotNull('promotions.to');
    }

    public function scopeHappenning($q) {
        return $q->whereRaw("now() between promotions.from and promotions.to")
        ->whereNotNull('promotions.from')->whereNotNull('promotions.to');
    }
}
