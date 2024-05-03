<div class="customer-info-wrapper d-flex">
    <a href="{{ $review->customer?->avatar_path }}" class="profile-avatar border"
        style="background: url({{ $review->customer?->avatar_path }})"></a> <span
        class="ps-3">{{ $review->customer?->fullname }}</span>
</div>
<div class="review-products">
    @if ($review->order)
        @foreach ($review->order->inventories as $inventory)
            <div class="d-flex py-1">
                <a href="{{ optional($inventory->image)->path_with_domain }}"
                    class="magnifig-img product-img img-thumbnail me-1"
                    style="background: url({{ optional($inventory->image)->path_with_domain }})"></a>
                <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{ $inventory->name }}</h6>
                    <p class="text-xs text-secondary mb-0">Phân loại: {{ $inventory->title }}</p>
                </div>
            </div>
        @endforeach
    @endif

</div>
