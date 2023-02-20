<span
    class="badge badge-pill bg-gradient-{{ App\Enums\PromotionStatusType::getColorClass($promotion->getStatus()) }}">{{ $promotion->promotion_status_label }}</span>
