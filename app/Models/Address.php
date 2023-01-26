<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'type',
        'details',
        'province_id',
        'district_id',
        'ward_id',
        'full_address',
        'featured',
        'fullname',
        'phone',
    ];

    public function ward() {
        return $this->belongsTo(Ward::class);
    }
    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function district() {
        return $this->belongsTo(District::class);
    }
}
