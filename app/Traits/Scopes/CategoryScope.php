<?php

namespace App\Traits\Scopes;

use App\Enums\CategoryType;
use App\Models\Category;

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

    public function scopeRelated($q, Category $category) {
        $tags = $category->tags()->pluck('tags.id')->toArray();
        return $q->where('categories.id', '!=', $category->id)->active()->with('image')->orderBy('order')->containTags($tags);
    }
}
