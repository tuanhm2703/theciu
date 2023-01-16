<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model {
    use HasFactory;
    public function pickup_address() {
        return $this->morphOne(Address::class, 'addressable')->where('type', AddressType::PICKUP);
    }
    public function pickup_addresses() {
        return $this->morphMany(Address::class, 'addressable')->where('type', AddressType::PICKUP);
    }
}
