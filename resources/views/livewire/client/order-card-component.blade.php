<div class="order-card px-3 pt-3 mb-3 show-detail-order"
    data-order-link="{{ $order->getOrderDetailLink() }}">
    <div class="text-right border-bottom">
        <h6 class="text-uppercase text-danger">{{ $order->getCurrentStatusLabel() }} | {{ $order->order_number }}</h6>
    </div>
    @foreach ($order->inventories as $inventory)
        <div class="d-flex py-3 justify-content-between order-row">
            <div class="row w-100">
                <div class="col-3 col-md-2">
                    <a href="{{ route('client.product.details', $inventory->product?->slug) }}" class="d-block"
                        style="background: url({{ optional($inventory->image)->path_with_domain }}); width: 70px; height: 70px; background-size: cover; background-position:center"></a>
                </div>
                <div class="col-9 col-md-8">
                    <div style="line-height: 1rem">
                        <h5 class="order-product-title">{{ $inventory->product?->name }}</h5>
                        <p class="text-large">Phân loại hàng: {{ $inventory->title }}</p>
                        <span class="font-weight-bold text-md">x{{ $inventory->pivot->quantity }}</span>
                    </div>
                </div>
                <div class="product-price d-none d-md-block col-md-2 text-right">
                    @if ($inventory->pivot->promotion_price < $inventory->pivot->origin_price)
                        <span class="old-price">{{ format_currency_with_label($inventory->pivot->origin_price) }}</span>
                        <span
                            class="new-price ml-1">{{ format_currency_with_label($inventory->pivot->promotion_price) }}</span>
                    @else
                        {{ format_currency_with_label($inventory->pivot->origin_price) }}
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <hr class="my-0">
    <div class="text-right order-footer-action d-flex align-items-center flex-row justify-content-between">
        <div class="order-note-wrapper">
            @switch($order->order_status)
                @case(App\Enums\OrderStatus::CANCELED)
                    @if ($order->canceled_by == App\Enums\OrderCanceler::CUSTOMER)
                        <small>Đã huỷ bởi bạn</small>
                    @else
                        <small>Đã huỷ bởi {{ $order->getCancelerLabel() }}</small>
                    @endif
                @break

                @case(2)
                @break

                @default
            @endswitch
        </div>
        <div class="action-button-wrapper">
            <div>
                Thành tiền: <span
                    class="font-weight-bold text-danger">{{ format_currency_with_label($order->getCustomerPayment()) }}</span>
            </div>
            <div class="mb-3 d-flex" style="justify-content: right">
                @switch($order->order_status)
                    @case(App\Enums\OrderStatus::CANCELED)
                    @break

                    @case(App\Enums\OrderStatus::WAIT_TO_ACCEPT)
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ $order->getShowCancelLink() }}">
                            Huỷ đơn hàng
                        </button>
                        @if (!$order->isPaid())
                            <button wire:click.prevent="pay()" class="d-block btn btn-primary text-white ml-2">
                                <span wire:loading.remove>Thanh toán</span>
                                <span wire:loading wire:target="pay">Đang triển khai...</span>
                            </button>
                        @endif
                    @break

                    @case(App\Enums\OrderStatus::WAITING_TO_PICK)
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ $order->getShowCancelLink() }}">Huỷ đơn
                            hàng</button>
                    @break

                    @case(App\Enums\OrderStatus::DELIVERED)
                        @if ($order->review_count === 0)
                            <button data-review-order-id="{{ $order->id }}" type="button"
                                class="d-block btn btn-primary ajax-modal-btn" data-modal-size="modal-lg"
                                data-link="{{ $order->getReviewOrderLink() }}">
                                Đánh giá
                            </button>
                        @endif

                        @default
                        @break

                    @endswitch
                    <a class="btn btn-light ml-2 d-none d-md-block"
                        href="{{ $order->getOrderDetailLink() }}">{{ trans('labels.view_order_details') }}</a>
                </div>
            </div>
        </div>
    </div>
