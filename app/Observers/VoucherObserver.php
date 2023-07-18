<?php

namespace App\Observers;

use App\Models\Voucher;

class VoucherObserver
{
    public function creating(Voucher $voucher) {
        $voucher->quantity = $voucher->total_quantity;
        if($voucher->isPrivate() || $voucher->isSystem()) {
            $voucher->saveable = false;
            $voucher->featured = false;
        }
    }
}
