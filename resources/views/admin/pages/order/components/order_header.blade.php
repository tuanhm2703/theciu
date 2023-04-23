<div class="d-flex order-header justify-content-between">
    <div class="customer-info-wrapper d-flex">
        <a href="{{ $order->customer->avatar_path }}" class="profile-avatar border"
            style="background: url({{ $order->customer->avatar_path }})"></a> <span
            class="ps-3">{{ $order->customer->fullname }}</span>
    </div>
    <div class="order-number">
        Mã đơn hàng: {{ $order->order_number }}
    </div>
</div>
