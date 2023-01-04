<div class="w-50 deal-product text-center m-auto">
    <figure class="product-media">
        <a href="{{ route('client.product.details', $product->slug) }}">
            <img src="{{ optional($product->image)->path_with_domain }}" alt="Product image" class="product-image">
        </a>

    </figure><!-- End .product-media -->

    <div class="product-body">
        <h3 class="product-title mt-1"><a href="{{ route('client.product.details', $product->slug) }}">{{ $product->name }}</a></h3>
        <!-- End .product-title -->
        @component('components.product-price-label', compact('product'))
        @endcomponent
    </div><!-- End .product-body -->
    <a href="{{ route('client.product.details', $product->slug) }}" class="action">Mua ngay</a>
</div>
