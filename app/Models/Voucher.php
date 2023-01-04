<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_type',
        'code',
        'status',
        'voucher_type_id',
        'voucher_type_id',
        'value',
        'min_order_value',
        'customer_limit',
        'quantity',
        'max_discount_amount',
        'begin',
        'end'
    ];
}
