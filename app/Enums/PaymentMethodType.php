<?php

namespace App\Enums;

class PaymentMethodType {
    const COD = 1;
    const EWALLET = 2;
    const EBANK = 3;

    const MOMO = 'momo';

    const REFUNDABLE_METHODS = [self::EWALLET, self::EBANK];
}
