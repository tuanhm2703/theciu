<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class CancelOrderRequestStatus extends Enum {
    const ACCEPTED = 1;
    const DISCARDED = 2;
    const WAITING = 0;
}
