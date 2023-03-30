<?php

namespace App\Observers;

use App\Models\Voucher;

class VoucherObserver
{
    public function creating(Voucher $voucher) {
        if($voucher->saveable) {
            $voucher->customer_limit = 1;
        }
    }
}
