<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class PaymentStatus extends Enum {
    const PENDING = 'Pending';
    const PAID = 'Paid';
    const FAILED = 'Failed';
    const REFUND = 'Refund';
    const REFUND_FAILED = 'RefundFailed';
}
