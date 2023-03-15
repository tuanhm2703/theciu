<div>
    @include('landingpage.layouts.pages.product.detail.first_attribute_select')
    @include('landingpage.layouts.pages.product.detail.second_attribute_select')
    <div class="details-filter-row details-row-size" wire:ignore>
        <label for="qty">{{ trans('labels.quantity') }}:</label>
        <div class="product-details-quantity">
            <input type="number" id="qty" class="form-control" value="1" min="1" max="10"
                step="1" data-decimals="0" required>
        </div><!-- End .product-details-quantity -->
    </div><!-- End .details-filter-row -->

    <div class="details-action-wrapper my-5">
        <a href="#" class="btn-product btn-wishlist" wire:click.prevent="addToWishlist"
            title="Wishlist"><span>{{ $product->is_on_customer_wishlist ? trans('labels.remove_from_wishlist') : trans('labels.add_to_wishlist') }}</span></a>
    </div><!-- End .details-action-wrapper -->

    <div class="product-details-action d-block my-5">
        <button @disabled(!$first_attribute_value || (!$second_attribute_value && $second_attributes->count() > 0)) wire:click.prevent="addToCart" class="btn-product btn-cart btn add-to-cart-btn">
            <span wire:loading.remove wire:target="addToCart">{{ trans('labels.add_to_cart') }}</span>
            <span wire:loading wire:target="addToCart">Đang thực hiện...</span>
        </button>
    </div>
    <div>
        <a href="#" id="size-guide-gallery">
            <i class="icon-th-list"></i>{{ trans('labels.size_guide') }} <br>
        </a>
        <div class="mt-1">
            @foreach ($product->size_rule_images as $image)
                <a style="background: url({{ $image->path_with_domain }})" class="size-rule-gallery img-thumbnail"
                    href="{{ $image->path_with_domain }}"></a>
            @endforeach
        </div>
    </div>
</div>
