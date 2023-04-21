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
                                    <img src="{{ $inventory->image->path_with_domain }}" alt="">
                                </figure>
                            </div>

                            <div>
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
        <div class="d-flex justify-content-between mt-1">
            <h5 class="d-flex align-items-center">
                <i class="text-danger fas fa-receipt mr-1"></i> Voucher
            </h5>
            <h6 class="d-flex align-items-center">
                @if ($order_voucher)
                    <div class="order-voucher-discount-tag mr-3 d-flex align-items-center wave-border">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                            x="0" y="0" viewBox="0 0 100 100"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="M96.74 28.63c.78-.06 1.39-.71 1.39-1.5V25c0-.83-.67-1.5-1.5-1.5H3.37c-.83 0-1.5.67-1.5 1.5v2.15c0 .77.58 1.41 1.34 1.49 1.34.14 2.35 1.25 2.35 2.59s-1.01 2.44-2.35 2.59c-.76.08-1.34.72-1.34 1.49v4.36c0 .77.58 1.41 1.34 1.49 1.34.14 2.35 1.25 2.35 2.59s-1.01 2.44-2.35 2.59c-.76.08-1.34.72-1.34 1.49v4.36c0 .77.58 1.41 1.34 1.49 1.34.14 2.35 1.25 2.35 2.59s-1.01 2.44-2.35 2.59c-.76.08-1.34.72-1.34 1.49v4.36c0 .77.58 1.41 1.34 1.49 1.34.14 2.35 1.25 2.35 2.59s-1.01 2.44-2.35 2.59c-.76.08-1.34.72-1.34 1.49v2.15c0 .83.67 1.5 1.5 1.5h93.26c.83 0 1.5-.67 1.5-1.5v-2.13c0-.78-.6-1.44-1.39-1.5-1.36-.1-2.43-1.24-2.43-2.59s1.07-2.49 2.43-2.59c.78-.06 1.39-.71 1.39-1.5v-4.34c0-.78-.6-1.44-1.39-1.5-1.36-.1-2.43-1.24-2.43-2.59s1.07-2.49 2.43-2.59c.78-.06 1.39-.71 1.39-1.5v-4.34c0-.78-.6-1.44-1.39-1.5-1.36-.1-2.43-1.24-2.43-2.59s1.07-2.49 2.43-2.59c.78-.06 1.39-.71 1.39-1.5v-4.34c0-.78-.6-1.44-1.39-1.5-1.36-.1-2.43-1.24-2.43-2.59s1.07-2.49 2.43-2.59zm-1.61 7.9v1.92c-2.22.76-3.81 2.87-3.81 5.3s1.59 4.54 3.81 5.3v1.92c-2.22.76-3.81 2.87-3.81 5.3s1.59 4.54 3.81 5.3v1.92c-2.22.76-3.81 2.87-3.81 5.3 0 1.97 1.04 3.72 2.61 4.72H5.96c1.57-1 2.6-2.75 2.6-4.72 0-2.4-1.51-4.47-3.69-5.26v-2c2.17-.79 3.69-2.86 3.69-5.26s-1.51-4.47-3.69-5.26v-2c2.17-.79 3.69-2.86 3.69-5.26s-1.51-4.47-3.69-5.26v-2a5.6 5.6 0 0 0 3.69-5.26c0-1.98-1.02-3.73-2.6-4.72h87.97c-1.57 1-2.61 2.76-2.61 4.72 0 2.43 1.59 4.54 3.81 5.3z"
                                    fill="#f93a3a" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span>
                            -{{ thousandsCurrencyFormat($order_voucher->getDiscountAmount($total)) }}
                        </span>
                    </div>
                @endif
                <a data-toggle="modal" data-target="#voucherListModal"
                    href="#">{{ trans('labels.pick_voucher') }}</a>
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
                            <td>{{ format_currency_with_label($type['fee']) }}</td>
                        </tr><!-- End .summary-shipping-row -->
                        <tr class="summary-shipping-row">
                            <td>
                                <div class="custom-control custom-radio">
                                    {{ trans('labels.received_date') }}
                                </div><!-- End .custom-control -->
                            </td>
                            <td>{{ $type['delivery_date'] }}</td>
                        </tr><!-- End .summary-shipping-row -->
                    @endforeach
                    <tr class="summary-shipping-estimate">
                        <td colspan="2" class="text-left">
                            <span>{{ optional($address)->full_address }}</span>
                            <br>
                            <a class="ajax-modal-btn" data-modal-size="modal-md" data-callback="initChangeModal()"
                                data-link="{{ route('client.auth.profile.address.view.change', ['selected_address_id' => $address ? $address->id : null]) }}">
                                {{ $address ? trans('labels.change_address') : trans('labels.pick_address') }}</a>
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
                                            class="mr-3"alt="">
                                        <span>{{ trans("labels.payment_methods.$pm->code") }} <i wire:ignore
                                                class="fa fa-question-circle" data-toggle="tooltip"
                                                data-placement="top"
                                                title="{{ $pm->description }}"></i></span></label>
                                </div><!-- End .custom-control -->
                            @endforeach
                        </td>
                    </tr>
                    <tr class="order-payment-info">
                        <td>{{ trans('labels.subtotal') }}</td>
                        <td>{{ format_currency_with_label($cart->getTotalWithSelectedItems($item_selected)) }}
                        </td>
                    </tr>
                    @if ($rank_discount_amount)
                        <tr class="order-payment-info">
                            <td width="50%">{{ trans('labels.discount_for_member') }}</td>
                            <td>- {{ format_currency_with_label($rank_discount_amount) }}
                            </td>
                        </tr>
                    @endif
                    @if ($order_voucher)
                        <tr class="order-payment-info">
                            <td>{{ trans('labels.order_discount_amount') }}</td>
                            <td>- {{ format_currency_with_label($order_voucher_discount) }}
                            </td>
                        </tr>
                    @endif
                    <tr class="order-payment-info">
                        <td>{{ trans('labels.shipping_fee') }}</td>
                        <td>{{ format_currency_with_label($shipping_fee) }}</td>
                    </tr>
                    <tr class="summary-total">
                        <td>{{ trans('labels.total') }}:</td>
                        <td>{{ format_currency_with_label($total - $order_voucher_discount + $shipping_fee) }}
                        </td>
                    </tr><!-- End .summary-total -->
                </tbody>
            </table><!-- End .table table-summary -->
            <div class="form-group">
                <label for="note" class="form-label">Chú thích đơn hàng</label>
                <textarea name="note" class="form-control w-100" wire:model.lazy="note" cols="30" rows="5"></textarea>
            </div>
            <button wire:click="checkOrder" href="#" id="checkout-btn"
                class="btn btn-outline-primary-2 btn-order btn-block">
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
                                    <span class="confirm-info">
                                        {{ format_currency_with_label($shipping_fee) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7">
                                    <span>{{ trans('labels.total') }}</span>
                                </div>
                                <div class="col-5 text-right">
                                    <span>{{ format_currency_with_label($total - $order_voucher_discount + $shipping_fee) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary mr-2" wire:click="checkout">
                            <span class="text-white" wire:loading.remove
                                wire:target="checkout">{{ trans('labels.checkout') }}</span>
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
