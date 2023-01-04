<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class PromotionType extends Enum {
    const DISCOUNT = 'discount';
    const FLASH_SALE = 'flash_sale';
}
