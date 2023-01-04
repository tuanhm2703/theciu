<?php

namespace App\Traits\Common;

use App\Models\User;

trait EditedBy {
    public function editor() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function author() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
