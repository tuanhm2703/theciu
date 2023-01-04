<?php

namespace App\Observers;

use App\Models\Promotion;

class PromotionObserver {
    public function creating(Promotion $promotion) {
        $promotion->slug = $promotion->generateUniqueSlug();
    }

    public function updating(Promotion $promotion) {
        if($promotion->isDirty('name')) {
            $promotion->slug = $promotion->generateUniqueSlug();
        }
    }
}
