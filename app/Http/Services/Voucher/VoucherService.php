<?php

namespace App\Http\Services\Voucher;

use App\Models\Customer;
use App\Models\Voucher;

class VoucherService {
    public function getUserCartVoucher(Customer $user) {
        $vouchers = Voucher::getCartVoucher($user)->get();
    }
}
