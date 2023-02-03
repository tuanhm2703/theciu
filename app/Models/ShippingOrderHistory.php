<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingOrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_order_id',
        'status',
        'status_code',
        'order_status',
        'time',
        'reason',
        'fee',
        'cod_amount',
    ];
}
