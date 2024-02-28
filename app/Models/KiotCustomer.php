<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiotCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'total_point',
        'reward_point',
        'kiot_customer_id',
        'data',
        'contact_number'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
