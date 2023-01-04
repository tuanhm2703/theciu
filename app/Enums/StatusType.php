<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class StatusType extends Enum {
    const ACTIVE = 1;
    const INACTIVE = 0;
}
