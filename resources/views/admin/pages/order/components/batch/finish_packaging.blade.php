<div class="card">
    <div class="card-header pb-0">
        <h6 class="d-flex justify-content-between align-items-center">Hoàn tất đóng gói hàng loạt
            <button class="btn btn-primary" id="submit-action-btn">Thực hiện xác nhận</button>
        </h6>
    </div>
    <div class="card-body">
        <div class="row border-bottom">
            <div class="col-2 border-end">
                <h6 class="text-center">Trạng thái</h6>
            </div>
            <div class="col-6 border-end">
                <h6>Mã đơn hàng</h6>
            </div>
            <div class="col-4">
                <h6>Giá trị đơn hàng</h6>
            </div>
        </div>
        @foreach ($orders as $order)
            <div class="row border-bottom">
                <div class="col-2 border-end pt-2 text-center status-label" data-order-id="{{ $order->id }}">
                    ...
                </div>
                <div class="col-6 border-end pt-2">{{ $order->order_number }}</div>
                <div class="col-4 pt-2">{{ format_currency_with_label($order->total) }}</div>
            </div>
        @endforeach
    </div>
</div>
