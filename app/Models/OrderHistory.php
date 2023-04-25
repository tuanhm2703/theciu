<?php

namespace App\Models;

use App\Traits\Common\Actionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model {
    use HasFactory;

    public function action() {
        return $this->belongsTo(Action::class);
    }

    public function executable() {
        return $this->morphTo();
    }

    public function executorLabel() {
        switch ($this->executable ? get_class($this->executable) : "") {
            case Customer::class:
                return 'Khách hàng';
            case User::class:
                return 'Cửa hàng';
            case ShippingService::class:
                return 'Dịch vụ vận chuyển';
            default:
                return 'Hệ thống';
        }
    }
}
