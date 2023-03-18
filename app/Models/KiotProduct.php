<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiotProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiot_product_id',
        'kiot_code',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];
}
