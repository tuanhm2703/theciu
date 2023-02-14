<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model {
    use HasFactory;

    protected $fillable = [
        'wishlistable_id',
        'wishlistable_type',
        'customer_id'
    ];

    public function products() {
        $this->morphedByMany(Product::class, 'wishlistable');
    }

    public function wishlistable() {
        return $this->morphTo();
    }
}
