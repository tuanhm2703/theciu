<?php

namespace App\Traits\Common;

use App\Enums\MediaType;
use App\Models\Category;

trait Categorizable {
    public function categories() {
        return $this->morphToMany(Category::class, 'categorizable');
    }
    public function category() {
        return $this->morphOne(Category::class, 'categorizable');
    }
}
