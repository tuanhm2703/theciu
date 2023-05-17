<?php

namespace App\Observers;

use App\Models\Voucher;

class VoucherObserver
{
    public function creating(Voucher $voucher) {
        $voucher->total_quantity = $voucher->quantity;
        if($voucher->isPrivate()) {
            $voucher->saveable = false;
            $voucher->featured = false;
        } else if($voucher->saveable) {
            $voucher->customer_limit = 1;
        }
    }
}
