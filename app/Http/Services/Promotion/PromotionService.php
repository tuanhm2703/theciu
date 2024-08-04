<?php

namespace App\Http\Services\Promotion;

use App\Enums\PromotionType;
use App\Models\Combo;
use App\Models\Promotion;

class PromotionService {
    public function getAvailableAccomGiftPromotionsForCart() {
        return Promotion::available()->whereType(PromotionType::ACCOM_GIFT)->with(['products.inventories' => function($q) {
            $q->where('inventories.promotion_status', 1)->where('inventories.stock_quantity', '>', 0);
        }, 'products.inventories.image', 'products.inventories.attributes', 'products.available_promotion'])->get();
    }

    public function getAvailableAccomProductPromotionsForCart() {
        return Promotion::available()->whereType(PromotionType::ACCOM_PRODUCT)->with(['products.inventories' => function($q) {
            $q->where('inventories.promotion_status', 1)->where('inventories.stock_quantity', '>', 0);
        }, 'products.inventories.image', 'products.inventories.attributes', 'products.available_promotion'])->get();
    }

    public function getAvailableCombo() {
        return Combo::available()->with(['products.inventories' => function($q) {
            $q->where('inventories.promotion_status', 1)->where('inventories.stock_quantity', '>', 0);
        }, 'products.inventories.image', 'products.inventories.attributes', 'products.available_promotion'])->get();
    }
}
