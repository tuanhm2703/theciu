<div class="product product-7 text-center">
    <figure class="product-media">
        @if ($product->is_has_sale)
            <span class="product-label label-sale">{{$product->discount_percent}}% off</span>
        @endif
        <a href="{{ route('client.product.details', ['slug' => $product->slug]) }}" class="product-image image-loading lazy d-none"
            style="background: url({{ optional($product->images->first())->path_with_domain }});"></a>
        @if ($product->available_flash_sales->first())
            <div class="product-countdown"
                data-until="{{ $product->available_flash_sales->first()->to->format('Y, m, d') }}"></div>
        @endif

        <div class="product-action-vertical">
            <button href="#" wire:click.prevent="addToWishlist"
                class="btn-product-icon btn-wishlist btn-expandable {{ $product->is_on_customer_wishlist ? 'on-wishlist' : '' }}"><span>{{ $product->is_on_customer_wishlist ? trans('labels.remove_from_wishlist') : trans('labels.add_to_wishlist') }}</span></span></a>
        </div><!-- End .product-action-vertical -->

        <div class="product-action">
            <a href="#"
                class="btn-product btn-cart add-to-cart-btn"><span>{{ trans('labels.add_to_cart') }}</span></a>
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
            @php
                $added_image_names = [];
            @endphp
            @foreach ($product->unique_attribute_inventories as $index => $inventory)
                @if ($inventory->image && !in_array($inventory->image->name, $added_image_names))
                    @php
                        $added_image_names[] = $inventory->image->name;
                    @endphp
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
