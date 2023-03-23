<?php

namespace App\Traits\Scopes;

use App\Enums\CategoryType;

trait CategoryScope {
    public function scopeTrending($q) {
        return $q->where('categories.type', CategoryType::TRENDING);
    }

    public function scopeNewArrival($q) {
        return $q->where('categories.type', CategoryType::NEW_ARRIVAL);
    }

    public function scopeBestSeller($q) {
        return $q->where('categories.type', CategoryType::BEST_SELLER);
    }
}
