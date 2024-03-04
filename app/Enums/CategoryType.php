<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class CategoryType extends Enum {
    const PRODUCT = 'product';
    const TRENDING = 'trending';
    const NEW_ARRIVAL = 'new-arrival';
    const BLOG = 'blog';
    const FEATURED = 'featured';
    const BEST_SELLER = 'best-seller';
    const COLLECTION = 'collection';
    const CAREER = 'career';

    public static function categoryTypeOptions() {
        return [
            self::TRENDING => trans("labels.category_types." . self::TRENDING),
            self::NEW_ARRIVAL => trans("labels.category_types." . self::NEW_ARRIVAL),
            self::BLOG => trans("labels.category_types." . self::BLOG),
            self::FEATURED => trans("labels.category_types." . self::FEATURED),
            self::BEST_SELLER => trans("labels.category_types." . self::BEST_SELLER),
            self::COLLECTION => trans("labels.category_types." . self::COLLECTION)
        ];
    }
    public static function productCategoryTypeOptions() {
        return [
            self::PRODUCT => trans("labels.category_types." . self::PRODUCT),
            self::COLLECTION => trans("labels.category_types." . self::COLLECTION)
        ];
    }
}
