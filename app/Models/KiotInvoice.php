<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\InvoiceResource;

class KiotInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'kiot_order_code',
        'kiot_invoice_id',
        'kiot_code',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function removeKiotInvoice()
    {
        try {
            $invoiceResource = new InvoiceResource(App::make(Client::class));
            $invoiceResource->remove($this->kiot_invoice_id);
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
