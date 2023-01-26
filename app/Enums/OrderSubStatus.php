<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class OrderSubStatus extends Enum {
    const PREPARING = 1;
    const FINISH_PACKAGING = 2;
}
