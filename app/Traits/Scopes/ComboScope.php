<?php

namespace App\Traits\Scopes;

use App\Enums\StatusType;

trait ComboScope {
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
        return $q->whereRaw("now() < combos.begin")
        ->whereNotNull('combos.begin')->whereNotNull('combos.end');
    }

    public function scopeHappenning($q) {
        return $q->whereRaw("now() between combos.begin and combos.end")
        ->whereNotNull('combos.begin')->whereNotNull('combos.end');
    }
}
