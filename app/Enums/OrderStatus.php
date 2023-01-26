<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class OrderStatus extends Enum {
    const ALL = 0;
    const WAIT_TO_ACCEPT = 1;
    const WAITING_TO_PICK = 2;
    const PICKING = 3;
    const DELIVERING = 4;
    const DELIVERED = 5;
    const CANCELED = 6;
    const RETURN = 7;
}
