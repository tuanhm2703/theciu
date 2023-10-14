<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Str;

class BlogObserver {
    public function creating(Blog $blog) {
        do {
            $blog->slug = stripVN($blog->title);
        } while (Blog::whereSlug($blog->slug)->exists());
    }

    public function updating(Blog $blog) {
        if ($blog->isDirty('title')) {
            $blog->slug = stripVN($blog->title);
        }
    }
}
