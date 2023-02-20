<div class="order-card px-3 pt-3 mb-3 show-detail-order"
    data-order-link="{{ route('client.auth.profile.order.details', $order->id) }}">
    <div class="text-right border-bottom">
        <h6 class="text-uppercase text-danger">{{ $order->getCurrentStatusLabel() }}</h6>
    </div>
    @foreach ($order->inventories as $inventory)
        <div class="d-flex py-3 justify-content-between">
            <div class="d-flex">
                <a href="{{ route('client.product.details', $inventory->product->slug) }}"
                    style="background: url({{ $inventory->image->path_with_domain }}); width: 70px; height: 70px; background-size: cover; background-position:center"></a>
                <div class="ml-3" style="line-height: 1rem">
                    <h5>{{ $inventory->product->name }}</h5>
                    <p class="text-large">Phân loại hàng: {{ $inventory->title }}</p>
                    <span class="font-weight-bold text-md">x{{ $inventory->pivot->quantity }}</span>
                </div>
            </div>
            <div class="product-price">
                @if ($inventory->pivot->promotion_price < $inventory->pivot->origin_price)
                    <span class="old-price">{{ format_currency_with_label($inventory->pivot->origin_price) }}</span>
                    <span class="new-price ml-1">{{ format_currency_with_label($inventory->pivot->promotion_price) }}</span>
                @else
                    {{ format_currency_with_label($inventory->pivot->origin_price) }}
                @endif
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
                Thành tiền: <span class="font-weight-bold text-danger">{{ format_currency_with_label($order->total) }}</span>
            </div>
            @switch($order->order_status)
                @case(App\Enums\OrderStatus::CANCELED)
                @break

                @case(App\Enums\OrderStatus::WAIT_TO_ACCEPT)
                    <div class="mb-3 d-flex" style="justify-content: right">
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ route('client.auth.profile.order.cancel.show', ['order' => $order->id]) }}">
                            Huỷ đơn hàng
                        </button>
                    </div>
                @break

                @case(App\Enums\OrderStatus::WAITING_TO_PICK)
                    <div class="mb-3 d-flex" style="justify-content: right">
                        <button type="button" class="d-block btn btn-light ajax-modal-btn"
                            data-link="{{ route('client.auth.profile.order.cancel.show', ['order' => $order->id]) }}">Huỷ đơn
                            hàng</button>
                    </div>
                @break

                @default
                @break
            @endswitch
        </div>
    </div>
</div>
