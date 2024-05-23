<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'from',
        'to',
        'content',
        'image_section',
        'slug',
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'event_product');
    }
}
