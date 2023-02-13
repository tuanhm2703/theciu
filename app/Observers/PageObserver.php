<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Str;

class PageObserver
{
    public function creating(Page $page) {
        $page->slug = Str::snake(stripVN($page->title), '-');
    }

    public function updating(Page $page) {
        $page->slug = Str::snake(stripVN($page->title), '-');
    }
}
