<div>
    @if (!empty($order))
        <div class="order-header d-flex justify-content-between bg-light p-3">
            <span class="text-uppercase w-25">
                < {{ trans('labels.return') }}</span>
                    <div class="w-100 text-right">
                        <span>{{ trans('labels.order_number') }}. {{ $order->order_number }}</span> | <span
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
        <div class="order-detail-action-wrapper mt-3 justify-content-end">
            @switch($order->order_status)
                @case(App\Enums\OrderStatus::CANCELED)
                @break

                @case(App\Enums\OrderStatus::WAIT_TO_ACCEPT)
                    <span></span>
                    <div class="d-flex" style="justify-content: right">
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ route('client.auth.profile.order.cancel.show', ['order' => $order->id]) }}">
                            {{ trans('labels.cancel_order') }}
                        </button>
                        @if (!$order->isPaid() && $order->payment_method->code != 'cod')
                            <button wire:click.prevent="pay()" class="d-block btn btn-primary text-white ml-2">
                                <span wire:loading.remove>{{ trans('labels.pay') }}</span>
                                <span wire:loading wire:target="pay">{{ trans('labels.loading') }}...</span>
                            </button>
                        @endif
                    </div>
                @break

                @case(App\Enums\OrderStatus::WAITING_TO_PICK)
                    <div class="d-flex" style="justify-content: right">
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ route('client.auth.profile.order.cancel.show', ['order' => $order->id]) }}">{{ trans('labels.cancel_order') }}</button>
                    </div>
                @break

                @case(App\Enums\OrderStatus::DELIVERED)
                    @if (!customer()->reviews()->whereOrderId($order->id)->exists())
                        <div class="d-flex" style="justify-content: right">
                            <button data-review-order-id="{{ $order->id }}" type="button"
                                class="d-block btn btn-primary ajax-modal-btn" data-modal-size="modal-lg"
                                data-link="{{ route('client.auth.profile.order.review', ['order' => $order->id]) }}">
                                Đánh giá
                            </button>
                        </div>
                    @endif
                @break

                @default
                @break
            @endswitch
        </div>
        <div class="order-shipping-address mt-3 mb-3">
            <div>
                <div class="border-color-gradient"></div>
            </div>
            <div>
                <div class="shipping-address-label align-items-baseline pt-3">
                    <h6>{{ trans('labels.shipping_address') }}</h6>
                    <div class="shipping-address-service-info">
                        <div class="d-flex flex-column">
                            <h6>{{ trans('labels.shipping_info') }}</h6>
                            <div>{{ $order->shipping_service->name }}</div>
                            <div>{{ $order->shipping_order->code }}</div>
                            <div class="order-history-phone mt-1">
                                @if ($order->order_histories->first())
                                    <ul class="mb-1">
                                        <li class="text-success">
                                            {{ $order->order_histories->sortByDesc('created_at')->first()->action->description }}
                                        </li>
                                    </ul>

                                    <a class="ajax-modal-btn" href="javascript:;" data-modal-size="modal-md"
                                        data-link="{{ route('client.auth.profile.order.shipping.detail', $order->id) }}">
                                        {{ trans('labels.see_more') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex shipping-info">
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
        <div class="pt-1 order-item-detail">
            @foreach ($order->inventories as $index => $inventory)
                <div class="row mb-2 pt-2 {{ $index == 0 ? 'border-top' : '' }}">
                    <div class="col-2 col-md-1">
                        <img class="rounded" width="100%" src="{{ optional($inventory->image)->path_with_domain }}"
                            alt="">
                    </div>
                    <div class="col-10 col-md-11">
                        <div class="row">
                            <div class="col-12 col-md-10" style="line-height: 2rem">
                                <div class="font-weight-bold">{{ $inventory->pivot->name }}</div>
                                <div class="confirm-label">x{{ $inventory->pivot->quantity }}</div>
                            </div>
                            <div class="col-12 col-md-2 text-right">
                                @if ($inventory->pivot->promotion_price < $inventory->pivot->origin_price)
                                    <span
                                        class="old-price">{{ format_currency_with_label($inventory->pivot->origin_price) }}</span>
                                    <span
                                        class="new-price ml-1">{{ format_currency_with_label($inventory->pivot->promotion_price) }}</span>
                                @else
                                    {{ format_currency_with_label($inventory->pivot->origin_price) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-top pt-2">
            <h6 class="mb-1">Chú thích đơn hàng</h6>
            <p><i>{{ $order->note }}</i></p>
            @if (!empty($order->bonus_note))
                <p class="text-danger"><i>Quà đi kèm:{{ $order->bonus_note }}</i></p>
            @endif
        </div>
        <div class="order-turnover-info text-right border-top pt-2" style="font-size: 14px;">
            <h6>{{ trans('labels.payment_info') }}</h6>
            <div class="row">
                <div class="col-8 border-right">
                    {{ trans('labels.subtotal') }}
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
                    @if ($order->freeship_voucher)
                        <span
                            class="text-line-through text-light">{{ format_currency_with_label($order->shipping_fee) }}</span>
                        <span>{{ format_currency_with_label($order->shipping_fee - $order->freeship_voucher->pivot->amount) }}</span>
                    @else
                        <span>{{ format_currency_with_label($order->shipping_fee) }}</span>
                    @endif
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
                    {{ trans('labels.discount_for_member') }}
                </div>
                <div class="col-4 text-right">
                    - {{ format_currency_with_label($order->rank_discount_value) }}
                </div>
            </div>
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
    <div class="voucher-popup container newsletter-popup-container d-none" id="review-voucher-gift">
    </div>
</div>
