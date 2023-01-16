<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class OrderStatus extends Enum {
    const ALL = 0;
    const WAIT_TO_ACCEPT = 1;
    const PICKING = 2;
    const DELIVERING = 3;
    const DELIVERED = 4;
    const CANCELED = 5;
    const RETURN = 6;
}
