<div class="product product-7 text-center">
    <figure class="product-media">
        @foreach ($product->images as $index => $image)
            <a href="{{ route('client.product.details', ['slug' => $product->slug]) }}"
                class="{{ $index == 0 ? 'product-image' : 'product-image-hover' }} lazy"
                style="background: url({{ $image->path_with_domain }});"></a>
        @endforeach

        <div class="product-action-vertical">
            <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
        </div><!-- End .product-action-vertical -->

        <div class="product-action">
            <a href="#" class="btn-product btn-cart add-to-cart-btn"><span>{{ trans('labels.add_to_cart') }}</span></a>
        </div><!-- End .product-action -->
    </figure><!-- End .product-media -->

    <div class="product-body">
        <div class="product-cat">
            <a
                href="{{ route('client.product.details', ['slug' => $product->slug]) }}">{{ $product->categories->first()->name }}</a>
        </div><!-- End .product-cat -->
        <h3 class="product-title"><a
                href="{{ route('client.product.details', ['slug' => $product->slug]) }}">{{ $product->name }}</a></h3>
        <!-- End .product-title -->
        @component('components.product-price-label', compact('product'))
        @endcomponent

        <div class="product-nav product-nav-thumbs intro-slider owl-carousel owl-theme owl-nav-inside owl-light"
            data-toggle="owl"
            data-owl-options='{
            "items": 4,
            "loop": false,
            "nav": false
        }'>
            @foreach ($product->unique_attribute_inventories as $index => $inventory)
                @if ($inventory->image)
                    <a href="{{ optional($inventory->image)->path_with_domain }}"
                        class="{{ $index == 0 ? 'active' : '' }} inventory-img-btn"
                        data-inventory-id="{{ $inventory->id }}"
                        style="background: url({{ optional($inventory->image)->path_with_domain }});">
                        {{-- <img src="{{ optional($inventory->image)->path_with_domain }}" alt="{{ $product->snake_name }}"> --}}
                    </a>
                @endif
            @endforeach
        </div><!-- End .product-nav -->
    </div><!-- End .product-body -->
</div><!-- End .product -->
