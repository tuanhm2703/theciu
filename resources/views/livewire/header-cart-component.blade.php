<div class="dropdown cart-dropdown" wire:init="loadContent">
    @if ($readyToLoad)
        <a href="{{ route('client.auth.cart.index') }}" id="cart-btn" class="dropdown-toggle" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
            <i class="icon-shopping-cart"></i>
            <span class="cart-count">{{ $cart ? $cart->inventories->count() : 0 }}</span>
        </a>
        @if ($cart)
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-cart-products">
                    @foreach ($cart->inventories as $inventory)
                        <div class="product">
                            <div class="product-cart-details">
                                <h4 class="product-title">
                                    <a
                                        href="{{ route('client.product.details', $inventory->product->slug) }}">{{ $inventory->name }}</a>
                                </h4>

                                <span class="cart-product-info">
                                    @if ($inventory->pivot)
                                        <span class="cart-product-qty">{{ $inventory->pivot->quantity }}</span>
                                    @else
                                        <span class="cart-product-qty">{{ $inventory->order_item->quantity }}</span>
                                    @endif
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
                    <span>{{ trans('labels.total') }}</span>

                    <span class="cart-total-price">{{ $cart->formatted_total }}</span>
                </div><!-- End .dropdown-cart-total -->

                <div class="dropdown-cart-action">
                    <a href="{{ route('client.auth.cart.index') }}">{{ trans('labels.view_cart') }}</a>
                </div><!-- End .dropdown-cart-total -->
            </div><!-- End .dropdown-menu -->
        @endif
    @else
        <a href="{{ route('client.auth.cart.index') }}" class="dropdown-toggle" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" data-display="static">
            <i class="icon-shopping-cart"></i>
            <span class="cart-count">{{ 0 }}</span>
        </a>
    @endif
</div><!-- End .cart-dropdown -->
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $('body').on('click', '#cart-btn', (e) => {
                window.location.href = `{{ route('client.auth.cart.index') }}`
            })
        })
    </script>
@endpush
