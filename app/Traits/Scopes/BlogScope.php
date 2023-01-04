<?php

namespace App\Traits\Scopes;

use Carbon\Carbon;

trait BlogScope {
    public function scopeAvailable($q) {
        return $q->active()->where('publish_date', '<=', Carbon::now());
    }
}
