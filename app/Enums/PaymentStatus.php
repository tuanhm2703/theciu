<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class PaymentStatus extends Enum {
    const PENDING = 'Pending';
    const WAIT = 'Paid';
}
