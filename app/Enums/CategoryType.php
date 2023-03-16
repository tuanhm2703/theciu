<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class CategoryType extends Enum {
    const PRODUCT = 'product';
    const SHOP = 'shop';
    const TRENDING = 'trending';
    const NEW_ARRIVAL = 'new-arrival';
    const BLOG = 'blog';
    const FEATURED = 'featured';
    const BEST_SELLER = 'best-seller';

    public static function categoryTypeOptions() {
        return [
            self::SHOP => trans("labels." . self::SHOP),
            self::TRENDING => trans("labels." . self::TRENDING),
            self::NEW_ARRIVAL => trans("labels." . self::NEW_ARRIVAL),
            self::BLOG => trans("labels." . self::BLOG),
            self::FEATURED => trans("labels." . self::FEATURED),
            self::BEST_SELLER => trans("labels." . self::BEST_SELLER)
        ];
    }
}
