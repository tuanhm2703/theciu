<p>Khách hàng: {{ $review->customer->full_name }}</p>
<div class="d-flex px-2 py-1">
        <a href="{{ optional($product->image)->path_with_domain }}" class="magnifig-img product-img img-thumbnail mx-1"
            style="background: url({{ optional($product->image)->path_with_domain }})"></a>
    <div class="d-flex flex-column justify-content-center">
        <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
        <p class="text-xs text-secondary mb-0">{{ trans('labels.product_sku') }}: {{ $product->sku }}</p>
    </div>
</div>
