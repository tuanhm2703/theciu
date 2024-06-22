<?php

namespace App\Http\Services\Promotion;

use App\Enums\PromotionType;
use App\Models\Combo;
use App\Models\Promotion;

class PromotionService {
    public function getAvailableAccomGiftPromotionsForCart() {
        return Promotion::available()->whereType(PromotionType::ACCOM_GIFT)->with('products')->get();
    }

    public function getAvailableAccomProductPromotionsForCart() {
        return Promotion::available()->whereType(PromotionType::ACCOM_PRODUCT)->with('products')->get();
    }

    public function getAvailableCombo() {
        return Combo::available()->with('products')->get();
    }
}
