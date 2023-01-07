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

        <div class="cart-bottom">
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

            <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i
                    class="icon-refresh"></i></a>
        </div><!-- End .cart-bottom -->
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
                    <tr class="summary-shipping">
                        <td>{{ trans('labels.shipping') }}:</td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr class="summary-shipping-row">
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="free-shipping" name="shipping"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="free-shipping">Free
                                    Shipping</label>
                            </div><!-- End .custom-control -->
                        </td>
                        <td>$0.00</td>
                    </tr><!-- End .summary-shipping-row -->

                    <tr class="summary-shipping-row">
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="standart-shipping" name="shipping"
                                    class="custom-control-input">
                                <label class="custom-control-label"
                                    for="standart-shipping">Standart:</label>
                            </div><!-- End .custom-control -->
                        </td>
                        <td>$10.00</td>
                    </tr><!-- End .summary-shipping-row -->

                    <tr class="summary-shipping-row">
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="express-shipping" name="shipping"
                                    class="custom-control-input">
                                <label class="custom-control-label"
                                    for="express-shipping">Express:</label>
                            </div><!-- End .custom-control -->
                        </td>
                        <td>$20.00</td>
                    </tr><!-- End .summary-shipping-row -->

                    <tr class="summary-shipping-estimate">
                        <td>{{ optional(auth('customer')->user()->address)->full_address }}<br>
                            <a class="ajax-modal-btn" data-modal-size="modal-md"
                                data-link="{{ route('client.auth.profile.address.view.change') }}">{{ trans('labels.change_address') }}</a>
                        </td>
                        <td>&nbsp;</td>
                    </tr><!-- End .summary-shipping-estimate -->

                    <tr class="summary-total">
                        <td>{{ trans('labels.total') }}:</td>
                        <td>$160.00</td>
                    </tr><!-- End .summary-total -->
                </tbody>
            </table><!-- End .table table-summary -->

            <a href="checkout.html"
                class="btn btn-outline-primary-2 btn-order btn-block">{{ trans('labels.checkout') }}</a>
        </div><!-- End .summary -->

        <a href="/"
            class="btn btn-outline-dark-2 btn-block mb-3"><span>{{ trans('labels.continue_shopping') }}</span><i
                class="icon-refresh"></i></a>
    </aside><!-- End .col-lg-3 -->
</div><!-- End .row -->
