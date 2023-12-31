<div class="row mt-2">
                    <div class="col-2 col-md-1">
                        <input wire:change="updateOrderInfo" type="checkbox"
                            class="form-control custom-checkbox m-auto check-cart-item p-1" value="{{ $inventory->id }}"
                            wire:model="item_selected">
                    </div>
                    <div class="col-9 col-md-10">
                        <div class="product-col">
                            <div class="cart-product px-2">
                                <figure class="product-media mr-1">
                                    <img src="{{ optional($inventory->image)->path_with_domain }}" alt="">
                                </figure>
                            </div>

                            <div>
                                @if ($inventory->product?->available_combo)
                                    <span style="width: fit-content; font-size: 12px; margin-bot: 3px"
                                        class="d-inline text-white bg-danger p-1 font-weight-bold text-uppercase">{{ $inventory->product?->available_combo?->name }}</span>
                                @endif
                                <h3 class="product-title">
                                    <a href="{{ route('client.product.details', $inventory->product->slug) }}"
                                        class="product-cart-title {{ $inventory->cart_stock > $inventory->stock_quantity ? 'text-danger' : '' }}">{{ $inventory->name }}</a>
                                    @if ($inventory->cart_stock > $inventory->stock_quantity && $inventory->product->is_reorder == 0)
                                        <br>
                                        <small><i
                                                class="text-danger">{{ trans('errors.cart.dont_have_enough_stock') }}</i></small>
                                    @endif
                                </h3><!-- End .product-title -->
                                <p>{{ $inventory->title }}</p>
                                @component('components.product-price-label', compact('inventory'))
                                @endcomponent
                                <div class="cart-product-quantity mt-1">
                                    <input type="number" class="form-control" min="1" max="10"
                                        step="1" data-decimals="0"
                                        wire:change="itemAdded({{ $inventory->id }}, $event.target.value)"
                                        data-inventory-id="{{ $inventory->id }}" value="{{ $inventory->cart_stock }}"
                                        required>
                                </div><!-- End .cart-product-quantity -->
                            </div>
                        </div><!-- End .product -->
                    </div>
                    <div class="col-1" wire:click="$emit('cart:itemDeleted', {{ $inventory->id }})"><button
                            class="btn-remove"><i class="icon-close"></i></button></div>
                </div>
