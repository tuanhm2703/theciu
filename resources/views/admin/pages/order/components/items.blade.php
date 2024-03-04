<div class="d-flex align-items-center">
    <div>
        @foreach ($order->inventories as $inventory)
            <div class="row mb-2">
                <div class="col-2">
                    <a href="#" class="magnifig-img product-img img-thumbnail mx-1"
                        style="background: url({{ optional($inventory->image)->path_with_domain }})"></a>
                </div>
                <div class="col-8" style="line-height: 0">
                    <p data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inventory->pivot->name }}"
                        class="cut-text text-bold">{{ $inventory->pivot->name }}</p>
                    <span>{{ $inventory->pivot->title }}</span>
                    @php
                        $promotion = $order->promotions->where('id', $inventory->pivot->promotion_id)->where('pivot.inventory_id', $inventory->id)->first();
                    @endphp
                    @if (in_array($promotion?->type, [App\Enums\PromotionType::ACCOM_GIFT, App\Enums\PromotionType::ACCOM_PRODUCT]) && $inventory->pivot?->promotion_price == 0)
                        <p class="text-primary mt-3"><i>Quà đi kèm</i></p>
                    @endif
                </div>
                <div class="col-2">
                    <span class="text-sm">{{ $inventory->pivot->quantity }}x</span>
                </div>
            </div>
        @endforeach
        @if ($order->note)
            <div class="mx-1 mt-3 w-100">
                <i style="white-space: normal;">Chú thích: {{ $order->note }}</i>
            </div>
        @endif
        @if ($order->bonus_note)
            <div class="mx-1 mt-1 w-100">
                <i style="white-space: normal;" class="text-dangers">Chú thích phần quà: {{ $order->bonus_note }}</i>
            </div>
        @endif
    </div>
</div>
