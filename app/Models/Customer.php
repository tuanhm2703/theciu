<?php

namespace App\Models;

use App\Traits\Common\Addressable;
use App\Traits\Common\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Customer extends User {
    use HasFactory, Addressable, Imageable, SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'phone',
        'email',
        'status',
        'provider',
    ];

    public function cart() {
        return $this->hasOne(Cart::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
