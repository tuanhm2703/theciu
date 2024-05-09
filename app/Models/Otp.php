<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'code',
        'expired_at',
        'customer_id'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function isExpired() {
        return now()->isAfter($this->expired_at->addSeconds(config('otp.expired_time')));
    }
}
