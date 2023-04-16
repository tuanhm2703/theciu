<?php

namespace App\Models;

use App\Traits\Common\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    use HasFactory, Metable;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'order'
    ];
}
