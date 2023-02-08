<div class="row">
    <div class="col-lg-9">
        <table class="table table-cart table-mobile">
            <thead>
                <tr>
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

        {{-- <div class="cart-bottom">
            <div class="cart-discount">
                <form action="#">
                    <div class="input-group">
                        <input type="text" class="form-control" required placeholder="coupon code">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary-2" type="submit"><i
                                    class="icon-long-arrow-right"></i></button>
                        </div><!-- .End .input-group-append -->
                    </div><!-- End .input-group -->
                </form>
            </div><!-- End .cart-discount -->

            <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
        </div><!-- End .cart-bottom --> --}}
    </div><!-- End .col-lg-9 -->
    <aside class="col-lg-3">
        <div class="summary summary-cart">
            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

            <table class="table table-summary">
                <tbody>
                    <tr class="summary-subtotal">
                        <td>{{ trans('labels.subtotal') }}:</td>
                        <td>{{ $cart->formatted_total }}</td>
                    </tr><!-- End .summary-subtotal -->
                    <tr class="summary-shipping position-relative">
                        <td>{{ trans('labels.shipping') }}: <span wire:loading class="spinner-border spinner-border-sm mr-3 position-absolute ml-3" style="top: 50%;" role="status" aria-hidden="true"></span></td>
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
                            <td>{{ format_currency($type['fee']) }}</td>
                        </tr><!-- End .summary-shipping-row -->
                        <tr class="summary-shipping-row">
                            <td>
                                <div class="custom-control custom-radio">
                                    Thời gian nhận hàng
                                </div><!-- End .custom-control -->
                            </td>
                            <td>{{ $type['delivery_date'] }}</td>
                        </tr><!-- End .summary-shipping-row -->
                    @endforeach
                    <tr class="summary-shipping-estimate">
                        <td colspan="2" class="text-left">
                            <span>{{ optional($address)->full_address }}</span>
                            <br>
                            <a class="ajax-modal-btn" data-modal-size="modal-md"
                                data-link="{{ route('client.auth.profile.address.view.change', ['selected_address_id' => $address ? $address->id : null]) }}">
                                  {{ $address ? trans('labels.change_address') : trans('labels.pick_address') }}</a>
                        </td>
                    </tr><!-- End .summary-shipping-estimate -->
                    <tr>
                        <td colspan="2">
                            @foreach ($payment_methods as $pm)
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="payment_method" wire:model="payment_method_id" required
                                        value="{{ $pm->id }}" id="payment-method-{{ $pm->id }}"
                                        @disabled($pm->canUse($cart->total()) === false) class="custom-control-input">
                                    <label for="payment-method-{{ $pm->id }}"
                                        class="custom-control-label d-flex align-items-center">
                                        <img src="{{ $pm->image->path_with_domain }}" width="10%"
                                            class="mr-3"alt="">
                                        <span>{{ trans("labels.payment_methods.$pm->code") }} <i wire:ignore
                                                class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
                                                title="{{ $pm->description }}"></i></span></label>
                                </div><!-- End .custom-control -->
                            @endforeach
                        </td>
                    </tr>

                    <tr class="summary-total">
                        <td>{{ trans('labels.total') }}:</td>
                        <td>{{ format_currency($cart->total() + $shipping_fee) }}</td>
                    </tr><!-- End .summary-total -->
                </tbody>
            </table><!-- End .table table-summary -->
            <button href="#" wire:click.prevent="checkout" class="btn btn-outline-primary-2 btn-order btn-block">
                <span wire:loading.remove wire:target="checkout">{{ trans('labels.checkout') }}</span>
                <span wire:loading wire:target="checkout">Đang tiến hành thanh toán..</span>
            </button>
            <div class="d-flex flex-column mt-1">
                @error('payment_method_id') <span class="text-danger">{{ $message }}</span> @enderror
                @error('service_id') <span class="text-danger">{{ $message }}</span> @enderror
                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div><!-- End .summary -->

        <a href="/"
            class="btn btn-outline-dark-2 btn-block mb-3"><span>{{ trans('labels.continue_shopping') }}</span><i
                class="icon-refresh"></i></a>
    </aside><!-- End .col-lg-3 -->
</div><!-- End .row -->
