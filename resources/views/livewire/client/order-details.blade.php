<div>
    @if (!empty($order))
        <div class="card-header d-flex justify-content-between bg-light p-3">
            <span class="text-uppercase w-25">< Trở lại</span>
            <div class="w-100 text-right">
                <span>Mã đơn hàng. {{ $order->order_number }}</span> | <span class="text-danger">{{$order->getCurrentStatusLabel()}}</span>
            </div>
        </div>
    @endif
</div>
