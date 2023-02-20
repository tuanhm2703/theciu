<div>
    @if (!empty($order))
        <div class="order-header d-flex justify-content-between bg-light p-3">
            <span class="text-uppercase w-25">
                < Trở lại</span>
                    <div class="w-100 text-right">
                        <span>Mã đơn hàng. {{ $order->order_number }}</span> | <span
                            class="text-danger">{{ $order->getCurrentStatusLabel() }}</span>
                    </div>
        </div>
        <div class="order-details-timeline mt-3">
            <div class="stepper {{ $order->order_histories->count() == 1 ? 'justify-content-center' : '' }}">
                @foreach ($order->order_histories as $history)
                    <div class="stepper__step stepper__step--finish">
                        <div class="stepper__step-icon stepper__step-icon--finish">
                            <i class="{{ $history->action->icon }}"></i>
                        </div>
                        <div class="stepper__step-text">{{ $history->action->name }}</div>
                        <div class="stepper__step-date">{{ $history->created_at->format('H:i d-m-Y') }}</div>
                    </div>
                @endforeach
                @if ($order->order_histories->count() > 1)
                    <div class="stepper__line">
                        <div class="stepper__line-background" style="background: rgb(224, 224, 224);"></div>
                        <div class="stepper__line-foreground"
                            style="width: calc((100% - 140px) * 1); background: rgb(45, 194, 88);"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="order-detail-action-wrapper mt-3">
            @switch($order->order_status)
                @case(App\Enums\OrderStatus::CANCELED)
                @break

                @case(App\Enums\OrderStatus::WAIT_TO_ACCEPT)
                    <span></span>
                    <div class="d-flex" style="justify-content: right">
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ route('client.auth.profile.order.cancel.show', ['order' => $order->id]) }}">
                            Huỷ đơn hàng
                        </button>
                        @if (!$order->isPaid())
                            <button wire:click.prevent="pay()" class="d-block btn btn-primary text-white ml-2">
                                <span wire:loading.remove>Thanh toán</span>
                                <span wire:loading wire:target="pay">Đang triển khai...</span>
                            </button>
                        @endif
                    </div>
                @break

                @case(App\Enums\OrderStatus::WAITING_TO_PICK)
                    <div class="d-flex" style="justify-content: right">
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ route('client.auth.profile.order.cancel.show', ['order' => $order->id]) }}">Huỷ đơn
                            hàng</button>
                    </div>
                @break

                @default
                @break
            @endswitch
        </div>
        <div class="order-shipping-address mt-3">
            <div>
                <div class="border-color-gradient"></div>
            </div>
            <div class="p-5">
                <div class="shipping-address-label">
                    <h6>Địa chỉ nhận hàng</h6>
                    <div class="shipping-address-service-info">
                        <div>
                            <div>{{ $order->shipping_service->name }}</div>
                            <div>{{ $order->shipping_order->code }}</div>
                            {{-- <div>Tài xế: Nguyễn Thái Dương, 84903691278</div> --}}
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="customer-address-info">
                        <div class="customer-address-name">{{ $order->shipping_address->fullname }}</div>
                        <div class="customer-detail-address">
                            <span>{{ $order->shipping_address->phone }}</span><br>{{ $order->shipping_address->full_address }}
                        </div>
                    </div>
                    <div class="shipping-order-history-wrapper">
                        <div>
                            @if (isset($order->shipping_order->shipping_order_histories))
                                @foreach ($order->shipping_order->shipping_order_histories as $index => $shipping_history)
                                    <div class="shipping-order-history-row {{ $index == 0 ? 'last-row' : '' }}">
                                        @if ($index < $order->shipping_order->shipping_order_histories->count() - 1)
                                            <div class="history-line"></div>
                                        @endif
                                        <div class="shipping-order-history-content">
                                            <div class="shipping-order-history-icon"></div>
                                            <div class="shipping-order-history-time">
                                                {{ $shipping_history->time->format('H:i d-m-Y') }}</div>
                                            <div class="shipping-order-history-description">
                                                <p class="shipping-order-history-status">
                                                    {{ $shipping_history->reason }}</p>
                                                <p>{{ $shipping_history->description }}
                                                    {{-- <div>Tài xế: Nguyễn Thái Dương, 84903691278</div> --}}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-turnover-info text-right" style="font-size: 14px;">
            <div class="row">
                <div class="col-8 border-right">
                    Tổng tiền hàng
                </div>
                <div class="col-4">
                    {{ format_currency_with_label($order->subtotal) }}
                </div>
            </div>
            <div class="row">
                <div class="col-8 border-right">
                    {{ trans('labels.shipping_fee') }}
                </div>
                <div class="col-4">
                    {{ format_currency_with_label($order->shipping_fee) }}
                </div>
            </div>
            @if ($order->order_voucher)
                <div class="row">
                    <div class="col-8 border-right">{{ trans('labels.order_voucher') }}</div>
                    <div class="col-4">
                        - {{ format_currency_with_label($order->order_voucher->pivot->amount) }}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-8 border-right">
                    {{ trans('labels.total') }}
                </div>
                <div class="col-4 text-right">
                    <h5 class="text-danger">
                        {{ format_currency_with_label($order->total) }}
                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-8 border-right">
                    {{ trans('labels.payment_method') }}
                </div>
                <div class="col-4">
                    {{ trans('labels.payment_methods.' . $order->payment->payment_method->code) }}
                </div>
            </div>
        </div>
    @endif
</div>
