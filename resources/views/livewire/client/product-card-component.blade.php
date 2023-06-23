<div class="product product-7 text-center">
    <figure class="product-media">
        @if ($product->is_has_sale)
            <span class="product-label label-sale">{{ round($product->discount_percent) }}% off</span>
        @endif
        <a href="{{ route('client.product.details', ['slug' => $product->slug]) }}"
            class="product-image image-loading lazy position-relative"
            style="background: url({{ $product->image?->product_lazy_load_path }});">
            <img width="1000" height="{{ $product->image?->getHeightFromRatio(300) }}"
                class="product-card-image" src="{{ $product->image?->getPathWithSize(300) }}" alt="{{ $product->name }}">
        </a>
        @if ($product->available_flash_sales->first())
            <div class="product-countdown"
                data-until="{{ $product->available_flash_sales->first()->to->format('Y, m, d, H, i, s') }}"></div>
        @endif

        <div class="product-action-vertical">
            <a href="#" wire:click.prevent="addToWishlist"
                class="btn-product-icon btn-wishlist btn-expandable {{ $product->is_on_customer_wishlist ? 'on-wishlist' : '' }}">
                <span>{{ $product->is_on_customer_wishlist ? trans('labels.remove_from_wishlist') : trans('labels.add_to_wishlist') }}</span>
            </a>
        </div><!-- End .product-action-vertical -->

        <div class="product-action">
            <a href="#" class="btn-product btn-cart add-to-cart-btn" wire:click="addToCart()"
                data-product-id="{{ $product->id }}">
                <div class="spinner-grow" role="status" wire:loading wire:target="addToCart">
                    <span class="sr-only">Loading...</span>
                </div>
                <span>{{ trans('labels.add_to_cart') }}</span>
            </a>
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
            "items": 2,
            "loop": false,
            "nav": false,
            "responsive": {
                "576": {
                    "items": 4
                },
                "482": {
                    "items": 3
                }
            }
        }'>
            @foreach ($inventory_images->unique('name') as $index => $image)
                @php
                    $image = (object) $image;
                @endphp
                <div class="p-1">
                    <a href="{{ $image->path_with_domain }}"
                        class="{{ $index == 0 ? 'active' : '' }} inventory-img-btn">
                        <img loading="lazy" src="{{ getPathWithSize(100, $image->path) }}"
                            alt="{{ $product->snake_name }}">
                    </a>
                </div>
            @endforeach
        </div><!-- End .product-nav -->
    </div><!-- End .product-body -->
</div><!-- End .product -->
