<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\InvoiceResource;

class KiotOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiot_order_id',
        'kiot_code',
        'order_id',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
