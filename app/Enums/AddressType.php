<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class AddressType extends Enum {
    const SHIPPING = 'shipping';
    const PRIMARY = 'primary';
}
