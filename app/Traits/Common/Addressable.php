<?php

namespace App\Traits\Common;

use App\Models\Address;

trait Addressable {
    public function addresses() {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function addresse() {
        return $this->morphOne(Address::class, 'addressable');
    }
}
