<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerData extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'key',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    protected $table = 'customer_data';
}
