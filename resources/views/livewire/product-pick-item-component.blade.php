<div>
    <h1 class="product-title">{{ $product->name }}</h1><!-- End .product-title -->
    @include('components.product-price-label')
    <div class="product-content">
        <p>{{ $product->short_description }}</p>
    </div><!-- End .product-content -->
    <div>
        @include('landingpage.layouts.pages.product.detail.first_attribute_select')
        @include('landingpage.layouts.pages.product.detail.second_attribute_select')
    </div>
    <div class="details-filter-row details-row-size">
        <label for="qty">{{ trans('labels.quantity') }}:</label>
        <div class="product-details-quantity">
            <input type="number" id="qty" class="form-control" value="1" min="1" @disabled(!$inventory) step="1" wire:model.lazy="quantity"
            max={{ $inventory ? $inventory->stock_quantity : 1 }}
                data-decimals="0" required>
        </div><!-- End .product-details-quantity -->
    </div><!-- End .details-filter-row -->

    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="product-details-action d-block m-0">
                <button @disabled(!$inventory) wire:click.prevent="addToCart"
                    class="btn-product btn-cart btn add-to-cart-btn">
                    <span wire:loading.remove wire:target="addToCart">{{ trans('labels.add_to_cart') }}</span>
                    <span wire:loading wire:target="addToCart">Đang thực hiện...</span>
                </button>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center add-to-wishlist-wrapper">
            <div class="details-action-wrapper m-0">
                <a href="#" class="btn-product btn-wishlist" wire:click.prevent="addToWishlist"
                    title="Wishlist"><span>{{ $product->is_on_customer_wishlist ? trans('labels.remove_from_wishlist') : trans('labels.add_to_wishlist') }}</span></a>
            </div><!-- End .details-action-wrapper -->
        </div>
    </div>
    <div class="mt-2">
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
