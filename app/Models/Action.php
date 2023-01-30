<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model {
    protected $fillable = [
        'name',
        'description',
        'icon',
        'slug',
    ];
    use HasFactory;
}
