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
                @if ($accom_gift_promotion)
                    <tr>
                        <td></td>
                        <td colspan="4" class="py-4">
                            <h6 class="text-center text-primary mb-0 text-uppercase font-weight-bold">Quà tặng đi kèm đơn
                                hàng > {{ format_currency_with_label($accom_gift_promotion->min_order_value) }}</h6>
                        </td>
                    </tr>
                    @foreach ($accom_gift_promotion->products as $index => $product)
                        @component('landingpage.layouts.pages.cart.components.accom-gift', compact('product', 'index'))
                        @endcomponent
                    @endforeach
                @endif
            </tbody>
        </table><!-- End .table table-wishlist -->
        <div class="mobile-cart-table">
            @foreach ($cart->inventories as $inventory)
                @component('landingpage.layouts.pages.cart.components.cart-row-mobile', compact('inventory'))
                @endcomponent
            @endforeach
            @if ($accom_gift_promotion)
                <h6 class="text-center text-primary mb-3 mt-5 py-3 border-bottom text-uppercase font-weight-bold">Quà
                    tặng đi
                    kèm đơn hàng > {{ format_currency_with_label($accom_gift_promotion->min_order_value) }}</h6>
                @foreach ($accom_gift_promotion->products as $index => $product)
                    @component('landingpage.layouts.pages.cart.components.accom-gift-mobile', compact('product', 'index'))
                    @endcomponent
                @endforeach
            @endif

        </div>
        <div class="d-flex justify-content-between bg-light mt-1 rounded cursor-pointer voucher-selector"
            data-toggle="modal" data-target="#voucherListModal">
            <h6 class="d-flex align-items-center mb-0 p-3 text-primary">
                <i class="text-primary fas fa-receipt mr-3"></i> Voucher
            </h6>
            <h6 class="d-flex align-items-center mb-0 p-3">
                <ul class="tags">
                    @if ($order_voucher)
                        <li><a
                                class="text-white">-{{ thousandsCurrencyFormat($order_voucher->getDiscountAmount($total)) }}</a>
                        </li>
                    @endif
                    @if ($freeship_voucher_id)
                        <li><a class="text-white">Miễn phí vận chuyển</a></li>
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
                                data-link="{{ customer() ? route('client.auth.profile.address.view.change', ['selected_address_id' => $address ? $address->id : null]) : route('client.address.view.change', ['selected_address_id' => $address ? $address->id : null]) }}">
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
                    @if ($additional_discount > 0)
                    <tr class="order-payment-info">
                        <td><span>Giảm giá chương trình</span></td>
                        <td><span>- {{ format_currency_with_label($additional_discount) }}</span></td>
                    </tr>
                @endif
                    <tr class="summary-total">
                        <td>{{ trans('labels.total') }}:</td>
                        <td>{{ format_currency_with_label($total) }}
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
                <span class="text-danger">{{ $error }}</span>
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
                                                {{ $inventory->cart_stock }}</span>
                                            <span class="confirm-label">Đơn giá:
                                                {{ format_currency_with_label($inventory->sale_price) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right">
                                        <span>{{ format_currency_with_label($inventory->sale_price * $inventory->cart_stock) }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach ($accom_inventories as $index => $inventory)
                            @if ($index == 0)
                                <h6
                                    class="text-center text-primary mb-0 pt-2 text-uppercase font-weight-bold border-top">
                                    Quà tặng đi
                                    kèm đơn
                                    hàng > {{ format_currency_with_label($accom_gift_promotion->min_order_value) }}
                                </h6>
                            @endif
                            <div class="row mb-2 pt-2 {{ $index == 0 && $accom_gift_promotion ? '' : 'border-top' }}">
                                <div class="col-2">
                                    <img class="rounded" width="100%"
                                        src="{{ optional($inventory->image)->path_with_domain }}" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="d-flex flex-column">
                                        <span>{{ $inventory->name }}</span>
                                        <span class="confirm-label">{{ trans('labels.quantity') }}:
                                            {{ $inventory->quantity_each_order }}</span>
                                    </div>
                                </div>
                                <div class="col-2 text-right">
                                    <span class="text-danger font-weight-bold">Quà đi kèm</span>
                                </div>
                            </div>
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
                            @if ($additional_discount > 0)
                                <div class="row mb-1">
                                    <div class="col-7">
                                        <span class="confirm-label">
                                            Giảm giá chương trình
                                        </span>
                                    </div>
                                    <div class="col-5 text-right">
                                        <span class="confirm-info">
                                            - {{ format_currency_with_label($additional_discount) }}
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
                                    <span>{{ format_currency_with_label($total) }}</span>
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
        window.addEventListener('open-confirm-order', (e) => {
            console.log(e.detail.show_lucky_shake);
            if (e.detail.show_lucky_shake) {
                $.magnificPopup.open({
                    items: {
                        src: "#lucky-shake",
                    },
                    type: "inline",
                    removalDelay: 350,
                    callbacks: {
                        open: function() {
                            $("body").css("overflow-x", "visible");
                            $(".sticky-header.fixed").css(
                                "padding-right",
                                "1.7rem"
                            );
                            setTimeout(() => {
                                $('.voucher-popup').removeClass('d-none')
                            }, 500);
                        },
                        close: function() {
                            $("body").css("overflow-x", "hidden");
                            $(".sticky-header.fixed").css("padding-right", "0");
                        },
                    },
                });
            } else {
                $.magnificPopup.close()
                $('#confirmOrderModal').modal('show')
            }
        });
        document.addEventListener("DOMContentLoaded", () => {
            // @this.on('open-confirm-order', (e) => {
            //     console.log(e);
            //     if (e.show_lucky_shake) {
            //         $.magnificPopup.open({
            //             items: {
            //                 src: "#lucky-shake",
            //             },
            //             type: "inline",
            //             removalDelay: 350,
            //             callbacks: {
            //                 open: function() {
            //                     $("body").css("overflow-x", "visible");
            //                     $(".sticky-header.fixed").css(
            //                         "padding-right",
            //                         "1.7rem"
            //                     );
            //                     setTimeout(() => {
            //                         $('.voucher-popup').removeClass('d-none')
            //                     }, 500);
            //                 },
            //                 close: function() {
            //                     $("body").css("overflow-x", "hidden");
            //                     $(".sticky-header.fixed").css("padding-right", "0");
            //                 },
            //             },
            //         });
            //     } else {
            //         $('#confirmOrderModal').modal('show')
            //     }
            // })
            quantityInputs()
            Livewire.hook('message.processed', (message, component) => {
                if (component.fingerprint.name == 'cart-component') {
                    quantityInputs()
                };
            })
        })
    </script>
@endpush
