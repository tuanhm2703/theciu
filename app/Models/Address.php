<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    use HasFactory;
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'type',
        'details',
        'province_id',
        'distict_id',
        'ward_id',
        'full_address',
        'fullname',
        'phone',
    ];

    public function ward() {
        return $this->belongsTo(Ward::class);
    }
}
