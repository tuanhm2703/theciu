<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class VoucherDiscountType extends Enum {
    const PERCENT = 'percentage';
    const AMOUNT = 'amount';

    public static function getDiscountTypeOptions() {
        return [self::PERCENT => 'Phần trăm', self::AMOUNT => 'Giảm tiền'];
    }
}
