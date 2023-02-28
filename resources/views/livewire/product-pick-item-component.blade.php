<div>
    @include('landingpage.layouts.pages.product.detail.first_attribute_select')
    @include('landingpage.layouts.pages.product.detail.second_attribute_select')
    <div class="details-filter-row details-row-size">
        <label for="qty">{{ trans('labels.quantity') }}:</label>
        <div class="product-details-quantity">
            <input type="number" id="qty" class="form-control" value="1" min="1" max="10"
                step="1" data-decimals="0" required>
        </div><!-- End .product-details-quantity -->
    </div><!-- End .details-filter-row -->

    <div class="product-details-action">
        <button @disabled(!$first_attribute_value || (!$second_attribute_value && $second_attributes->count() > 0)) wire:click.prevent="addToCart" class="btn-product btn-cart btn">
            <span wire:loading.remove wire:target="addToCart">{{ trans('labels.add_to_cart') }}</span>
            <span wire:loading wire:target="addToCart">Đang thực hiện...</span>
        </button>
        <div class="details-action-wrapper">
            <a href="#" class="btn-product btn-wishlist" wire:click.prevent="addToWishlist"
                title="Wishlist"><span>{{ $product->is_on_customer_wishlist ? trans('labels.remove_from_wishlist') : trans('labels.add_to_wishlist') }}</span></a>
        </div><!-- End .details-action-wrapper -->
    </div><!-- End .product-details-action -->
</div>
