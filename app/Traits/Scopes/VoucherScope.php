<?php

namespace App\Traits\Scopes;

trait VoucherScope {
    public function scopeCanApplyForCustomer($q, $customer_id) {

    }

    public function scopeAvailable($q) {
        $now = now();
        return $q->whereRaw("'$now' between vouchers.begin and vouchers.end");
    }
}
