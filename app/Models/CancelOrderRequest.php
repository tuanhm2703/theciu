<?php

namespace App\Models;

use App\Enums\CancelOrderRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelOrderRequest extends Model {
    use HasFactory;
    protected $fillable = [
        'status',
        'order_id',
        'customer_id',
        'cancel_reason',
        'executable_id',
        'executable_type'
    ];

    public function accept() {
        $executable_id = auth()->check() ? auth()->user()->id : null;
        $executable_type = null;
        if (auth('api')->check()) $executable_type = 'App\Models\Customer';
        if (auth('web')->check()) $executable_type = 'App\Models\User';

        $this->fill([
            'status' => CancelOrderRequestStatus::ACCEPTED,
            'executable_id' => $executable_id,
            'executable_type' => $executable_type
        ]);
        $this->save();
    }
    public function discard() {
        $executable_id = auth()->check() ? auth()->user()->id : null;
        $executable_type = null;
        if (auth('api')->check()) $executable_type = 'App\Models\Customer';
        if (auth('web')->check()) $executable_type = 'App\Models\User';

        $this->fill([
            'status' => CancelOrderRequestStatus::DISCARDED,
            'executable_id' => $executable_id,
            'executable_type' => $executable_type
        ]);
        $this->save();
    }

    public function executable() {
        return $this->morphTo();
    }
}
