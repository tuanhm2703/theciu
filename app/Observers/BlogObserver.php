<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Str;

class BlogObserver {
    public function creating(Blog $blog) {
        if ($blog->code == null) {
            $blog->migrateUniqueCode();
        }
        $blog->slug = Str::snake(stripVN($blog->title), '-');
    }

    public function updating(Blog $blog) {
        if ($blog->isDirty('title')) {
            $blog->slug = Str::snake(stripVN($blog->title), '-');
        }
    }
}
