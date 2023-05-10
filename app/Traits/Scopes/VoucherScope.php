<?php

namespace App\Traits\Scopes;

use App\Enums\DisplayType;

trait VoucherScope {
    public function scopeCanApplyForCustomer($q, $customer_id) {

    }

    public function scopeAvailable($q) {
        return $q->whereRaw("now() between vouchers.begin and vouchers.end");
    }

    public function scopeNotExpired($q) {
        return $q->whereRaw('vouchers.end >= now()');
    }

    public function scopeNotSaveable($q) {
        return $q->where('vouchers.saveable', 0);
    }

    public function scopeSaveable($q) {
        return $q->where('vouchers.saveable', 1);
    }

    public function scopeHaveNotUsed($q) {
        return $q->where('customer_vouchers.is_used', 0);
    }

    public function scopeFeatured($q) {
        return $q->where('vouchers.featured', 1);
    }

    public function scopePublic($q) {
        return $q->where('vouchers.display', DisplayType::PUBLIC);
    }
}
