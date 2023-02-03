<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;

    protected $fillable = [
        'amount',
        'payment_status',
        'trans_id',
        'order_number',
        'data',
        'payment_method_id',
        'order_id',
        'customer_id',
        'note'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function payment_method() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
