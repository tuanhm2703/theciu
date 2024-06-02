<?php

namespace App\Models;

use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    use HasFactory, CustomScope;
    protected $fillable = [
        'name'
    ];
}
