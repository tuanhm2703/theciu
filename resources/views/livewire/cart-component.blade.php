<div class="row">
    <div class="col-lg-9">
        <table class="table table-cart table-mobile mb-2 desktop-cart-table">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ trans('labels.product') }}</th>
                    <th>{{ trans('labels.price') }}</th>
                    <th>{{ trans('labels.quantity') }}</th>
                    <th>{{ trans('labels.total') }}</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cart->inventories as $inventory)
                    @component('landingpage.layouts.pages.cart.components.cart-row', compact('inventory'))
                    @endcomponent
                @endforeach
            </tbody>
        </table><!-- End .table table-wishlist -->
        <div class="mobile-cart-table">
            @foreach ($cart->inventories as $inventory)
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
                                        class="product-cart-title {{ $inventory->pivot->quantity > $inventory->stock_quantity ? 'text-danger' : '' }}">{{ $inventory->name }}</a>
                                    @if ($inventory->pivot->quantity > $inventory->stock_quantity && $inventory->product->is_reorder == 0)
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
                                        data-inventory-id="{{ $inventory->id }}"
                                        value="{{ $inventory->pivot->quantity }}" required>
                                </div><!-- End .cart-product-quantity -->
                            </div>
                        </div><!-- End .product -->
                    </div>
                    <div class="col-1" wire:click="$emit('cart:itemDeleted', {{ $inventory->id }})"><button
                            class="btn-remove"><i class="icon-close"></i></button></div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between bg-light mt-1 rounded cursor-pointer voucher-selector"
            data-toggle="modal" data-target="#voucherListModal">
            <h6 class="d-flex align-items-center mb-0 p-3 text-primary">
                <i class="text-primary fas fa-receipt mr-3"></i> Voucher
            </h6>
            <h6 class="d-flex align-items-center mb-0 p-3">
                <ul class="tags">
                    @if ($order_voucher)
                        <li><span>-{{ thousandsCurrencyFormat($order_voucher->getDiscountAmount($total)) }}</span>
                        </li>
                    @endif
                    @if ($freeship_voucher_id)
                        <li><span>Miễn phí vận chuyển</span></li>
                    @endif
                </ul>
                <span class="text-light ml-3">
                    <i class="fas fa-angle-right"></i>
                </span>
                {{-- <a data-toggle="modal" data-target="#voucherListModal" class="ml-1"
                    href="#">{{ trans('labels.pick_voucher') }}</a> --}}
            </h6>
        </div>

    </div><!-- End .col-lg-9 -->
    <aside class="col-lg-3">
        <div class="summary summary-cart">
            <h3 class="summary-title d-flex align-items-center">
                <img src="{{ getLogoUrl() }}" class="mr-3" width="90" alt="">
                <div class="pl-3">{{ trans('labels.checkout') }}</div>
            </h3><!-- End .summary-title -->

            <table class="table table-summary">
                <tbody>
                    <tr class="summary-shipping position-relative">
                        <td>{{ trans('labels.shipping') }}: <span wire:loading
                                class="spinner-border spinner-border-sm mr-3 position-absolute ml-3" style="top: 50%;"
                                role="status" aria-hidden="true"></span></td>
                        <td>&nbsp;</td>
                    </tr>
                    @foreach ($shipping_service_types as $type)
                        @php
                            $type = (array) $type;
                        @endphp
                        <tr class="summary-shipping-row">
                            <td>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="shipping" wire:model="service_id"
                                        value="{{ $type['service_id'] }}" id="ship-service-{{ $type['service_id'] }}"
                                        class="custom-control-input">
                                    <label for="ship-service-{{ $type['service_id'] }}"
                                        class="custom-control-label">{{ $type['short_name'] }}</label>
                                </div><!-- End .custom-control -->
                            </td>
                            <td><span>{{ format_currency_with_label($type['fee']) }}</span></td>
                        </tr><!-- End .summary-shipping-row -->
                        <tr class="summary-shipping-row">
                            <td>
                                <div class="custom-control custom-radio">
                                    <span>{{ trans('labels.received_date') }} </span>
                                </div><!-- End .custom-control -->
                            </td>
                            <td><span>{{ $type['delivery_date'] }}</span></td>
                        </tr><!-- End .summary-shipping-row -->
                    @endforeach
                    <tr class="summary-shipping-estimate">
                        <td colspan="2" class="text-left">
                            <span>{{ optional($address)->full_address }}</span>
                            <br>
                            <a class="ajax-modal-btn" data-modal-size="modal-md" data-callback="initChangeModal()"
                                data-link="{{ route('client.auth.profile.address.view.change', ['selected_address_id' => $address ? $address->id : null]) }}">
                                <span>{{ $address ? trans('labels.change_address') : trans('labels.pick_address') }}</span></a>
                        </td>
                    </tr><!-- End .summary-shipping-estimate -->
                    <tr>
                        <td colspan="2">
                            @foreach ($payment_methods as $pm)
                                <div class="custom-control custom-radio payment-method-row">
                                    <input type="radio" name="payment_method" wire:model="payment_method_id" required
                                        value="{{ $pm->id }}" id="payment-method-{{ $pm->id }}"
                                        @disabled($pm->canUse($total + $shipping_fee + $order_voucher_discount) === false) class="custom-control-input">
                                    <label for="payment-method-{{ $pm->id }}"
                                        class="custom-control-label d-flex align-items-center">
                                        <img src="{{ optional($pm->image)->path_with_domain }}" width="10%"
                                            class="mr-3 rounded" alt="">
                                        <span>{{ trans("labels.payment_methods.$pm->code") }} <i wire:ignore
                                                class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
                                                title="{{ $pm->description }}"></i></span></label>
                                </div><!-- End .custom-control -->
                            @endforeach
                        </td>
                    </tr>
                    <tr class="order-payment-info">
                        <td><span>{{ trans('labels.subtotal') }}</span></td>
                        <td><span>{{ format_currency_with_label($cart->getTotalWithSelectedItems($item_selected)) }}</span>
                        </td>
                    </tr>
                    @if ($rank_discount_amount)
                        <tr class="order-payment-info">
                            <td width="50%"><span>{{ trans('labels.discount_for_member') }}</span></td>
                            <td><span>- {{ format_currency_with_label($rank_discount_amount) }}</span></td>
                        </tr>
                    @endif
                    @if ($order_voucher)
                        <tr class="order-payment-info">
                            <td><span>{{ trans('labels.order_discount_amount') }}</span></td>
                            <td><span>- {{ format_currency_with_label($order_voucher_discount) }}</span></td>
                        </tr>
                    @endif
                    <tr class="order-payment-info">
                        <td><span>{{ trans('labels.shipping_fee') }}</span></td>
                        @if ($freeship_voucher_discount)
                            <td>
                                <span
                                    class="text-line-through text-light">{{ format_currency_with_label($shipping_fee) }}</span>
                                <span>{{ format_currency_with_label($shipping_fee - $freeship_voucher_discount < 0 ? 0 : $shipping_fee - $freeship_voucher_discount) }}</span>
                            </td>
                        @else
                            <td><span>{{ format_currency_with_label($shipping_fee) }}</span></td>
                        @endif
                    </tr>
                    @if ($combo_discount > 0)
                        <tr class="order-payment-info">
                            <td><span>{{ trans('labels.combo_discount') }}</span></td>
                            <td><span>- {{ format_currency_with_label($combo_discount) }}</span></td>
                        </tr>
                    @endif
                    <tr class="summary-total">
                        <td>{{ trans('labels.total') }}:</td>
                        <td>{{ format_currency_with_label($total - $order_voucher_discount + $shipping_fee - $freeship_voucher_discount) }}
                        </td>
                    </tr><!-- End .summary-total -->
                </tbody>
            </table><!-- End .table table-summary -->
            <div class="form-group">
                <label for="note" class="form-label">Chú thích đơn hàng</label>
                <textarea name="note" class="form-control w-100" wire:model.lazy="note" cols="30" rows="5"></textarea>
            </div>
            <button wire:click.prevent="checkOrder" id="checkout-btn" wire:loading.attr="disabled"
                wire:target="checkOrder" class="btn btn-outline-primary-2 btn-order btn-block">
                <span wire:loading.remove wire:target="checkOrder">{{ trans('labels.checkout') }}</span>
                <span wire:loading wire:target="checkOrder">Đang tiến hành thanh toán..</span>
            </button>
            <div class="d-flex flex-column mt-1">
                @error('payment_method_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('service_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('item_selected')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('note')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div><!-- End .summary -->

        <a href="/"
            class="btn btn-outline-dark-2 btn-block mb-3"><span>{{ trans('labels.continue_shopping') }}</span><i
                class="icon-refresh"></i></a>
    </aside><!-- End .col-lg-3 -->
    @include('landingpage.layouts.pages.cart.components.voucher')
    <div class="modal fade" id="confirmOrderModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalSignTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <div class="d-flex align-items-center justify-content-center bg-light p-4">
                        <img src="{{ getLogoUrl() }}" alt="{{ getAppName() }} - Logo" width="20%">
                    </div>
                </div>
                <div class="modal-body p-4 p-md-5 pt-0">
                    <h6 class="text-uppercase text-center font-weight-bold py-5 mb-0 ">Kiểm tra thông tin đơn hàng</h6>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-3">
                                <span class="confirm-label">Ngày tạo đơn</span>
                            </div>
                            <div class="col-4">
                                <span class="confirm-label">Phương thức thanh toán</span>
                            </div>
                            <div class="col-5">
                                <span class="confirm-label">Địa chỉ giao hàng</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <span class="confirm-info">{{ now()->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-4">
                                @if ($payment_method_id)
                                    <span
                                        class="confirm-info">{{ trans('labels.payment_methods.' . $payment_methods->where('id', $payment_method_id)->first()->code) }}</span>
                                @endif
                            </div>
                            <div class="col-5">
                                <span class="confirm-info">{{ optional($address)->full_address }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="pr-3">
                        @foreach ($cart->inventories as $inventory)
                            @if (in_array($inventory->id, $item_selected))
                                <div class="row mb-2 pt-2 border-top">
                                    <div class="col-2">
                                        <img class="rounded" width="100%"
                                            src="{{ optional($inventory->image)->path_with_domain }}" alt="">
                                    </div>
                                    <div class="col-8">
                                        <div class="d-flex flex-column">
                                            <span>{{ $inventory->name }}</span>
                                            <span class="confirm-label">{{ trans('labels.quantity') }}:
                                                {{ $inventory->pivot->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right">
                                        <span>{{ format_currency_with_label($inventory->sale_price) }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="border-top py-3">
                        <span class="confirm-label">Chú thích đơn hàng</span>
                        <br>
                        <span><i class="font-weight-normal">{{ $note }}</i></span>
                    </div>
                    <div class="row mb-3 pr-3 pt-2">
                        <div class="col-12 offset-md-4 offset-lg-6 col-md-8 col-lg-6">
                            <div class="row mb-1">
                                <div class="col-7">
                                    <span class="confirm-label">{{ trans('labels.subtotal') }}</span>
                                </div>
                                <div class="col-5 text-right">
                                    <span
                                        class="confirm-info">{{ format_currency_with_label($cart->getTotalWithSelectedItems($item_selected)) }}</span>
                                </div>
                            </div>
                            @if ($rank_discount_amount)
                                <div class="row mb-1">
                                    <div class="col-7">
                                        <span class="confirm-label">
                                            {{ trans('labels.discount_for_member') }}
                                        </span>
                                    </div>
                                    <div class="col-5 text-right">
                                        <span class="confirm-info">
                                            - {{ format_currency_with_label($rank_discount_amount) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            @if ($order_voucher)
                                <div class="row mb-1">
                                    <div class="col-7">
                                        <span class="confirm-label">
                                            {{ trans('labels.order_discount_amount') }}
                                        </span>
                                    </div>
                                    <div class="col-5 text-right">
                                        <span class="confirm-info">
                                            - {{ format_currency_with_label($order_voucher_discount) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-1">
                                <div class="col-7">
                                    <span class="confirm-label">
                                        {{ trans('labels.shipping_fee') }}
                                    </span>
                                </div>
                                <div class="col-5 text-right">
                                    @if ($freeship_voucher_discount)
                                        <span class="confirm-info text-line-through text-light">
                                            {{ format_currency_with_label($shipping_fee) }}
                                        </span>
                                        <span class="confirm-info">
                                            {{ format_currency_with_label($shipping_fee - $freeship_voucher_discount) }}
                                        </span>
                                    @else
                                        <span class="confirm-info">
                                            {{ format_currency_with_label($shipping_fee) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7">
                                    <span class="confirm-label">
                                        {{ trans('labels.combo_discount') }}
                                    </span>
                                </div>
                                <div class="col-5 text-right">
                                    <span class="confirm-info">
                                        - {{ format_currency_with_label($combo_discount) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7">
                                    <span>{{ trans('labels.total') }}</span>
                                </div>
                                <div class="col-5 text-right">
                                    <span>{{ format_currency_with_label($total + $shipping_fee - $order_voucher_discount - $freeship_voucher_discount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary mr-2" wire:click="checkout" wire:loading.attr="disabled"
                            wire:target="checkout">
                            <span class="text-white" wire:loading.remove
                                wire:target="checkout">{{ trans('labels.confirm') }}</span>
                            <span class="text-white" wire:loading wire:target="checkout">Đang tiến hành thanh
                                toán..</span>
                        </button>
                        <button class="btn btn-default" data-dismiss="modal">
                            <span>Huỷ</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @this.on('open-confirm-order', (e) => {
                $('#confirmOrderModal').modal('show')
            })
            quantityInputs()
            Livewire.hook('message.processed', (message, component) => {
                if (component.fingerprint.name == 'cart-component') {
                    quantityInputs()
                };
            })
        })
    </script>
@endpush
