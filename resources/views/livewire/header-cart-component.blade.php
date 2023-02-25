<div class="dropdown cart-dropdown">
    <a href="{{ route('client.auth.cart.index') }}" class="dropdown-toggle" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" data-display="static">
        <i class="icon-shopping-cart"></i>
        <span class="cart-count">{{ $cart ? $cart->inventories->count() : 0 }}</span>
        <span class="cart-txt">{{ $cart ? $cart->formatted_total : 0 }}</span>
    </a>

    @if ($cart)
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-cart-products">
                @foreach ($cart->inventories as $inventory)
                    <div class="product">
                        <div class="product-cart-details">
                            <h4 class="product-title">
                                <a
                                    href="{{ route('client.product.details', $inventory->product->slug) }}">{{ $inventory->product->name }}</a>
                            </h4>

                            <span class="cart-product-info">
                                <span class="cart-product-qty">{{ $inventory->pivot->quantity }}</span>
                                x {{ $inventory->formatted_sale_price }}
                            </span>
                        </div><!-- End .product-cart-details -->

                        <figure class="product-image-container">
                            <a href="{{ route('client.product.details', $inventory->product->slug) }}"
                                class="product-image">
                                <img src="{{ optional($inventory->image)->path_with_domain }}" alt="product">
                            </a>
                        </figure>
                        <a href="#" class="btn-remove remove-cart-item-btn"
                            wire:click.prevent="deleteInventory({{ $inventory->id }})"
                            data-inventory-id="{{ $inventory->id }}" title="Remove Product"><i
                                class="icon-close"></i></a>
                    </div><!-- End .product -->
                @endforeach
            </div><!-- End .cart-product -->

            <div class="dropdown-cart-total">
                <span>Total</span>

                <span class="cart-total-price">{{ $cart->formatted_total }}</span>
            </div><!-- End .dropdown-cart-total -->

            <div class="dropdown-cart-action">
                <a href="{{ route('client.auth.cart.index') }}">{{ trans('labels.view_cart') }}</a>
                {{-- <a href="checkout.html" class="btn btn-outline-primary-2"><span>{{ trans('labels.checkout') }}</span><i
                        class="icon-long-arrow-right"></i></a> --}}
            </div><!-- End .dropdown-cart-total -->
        </div><!-- End .dropdown-menu -->
    @endif
</div><!-- End .cart-dropdown -->
