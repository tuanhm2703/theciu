<?php

namespace App\Traits\Common;

use App\Enums\AddressType;
use App\Models\Address;

trait Addressable {
    public function addresses() {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function address() {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function shipping_addresses() {
        return $this->morphMany(Address::class, 'addressable')->where('type', AddressType::SHIPPING)->orderBy('featured', 'desc');
    }

    public function primary_address() {
        return $this->morphOne(Address::class, 'addressable')->whereType(AddressType::PRIMARY);
    }

    public function shipping_address() {
        return $this->morphOne(Address::class, 'addressable')->where('type', AddressType::SHIPPING)->where('featured', 1);
    }

    public function pickup_address() {
        return $this->morphOne(Address::class, 'addressable')->where('type', AddressType::PICKUP)->orderBy('featured', 'desc');
    }
    public function pickup_addresses() {
        return $this->morphMany(Address::class, 'addressable')->where('type', AddressType::PICKUP)->orderBy('featured', 'desc');
    }
}
