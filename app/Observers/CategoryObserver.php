<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver {
    public function creating(Category $category) {
        $category->slug = $category->generateUniqueSlug();
    }

    public function updating(Category $category) {
        if($category->isDirty('name')) {
            $category->slug = $category->generateUniqueSlug();
        }
    }
}
