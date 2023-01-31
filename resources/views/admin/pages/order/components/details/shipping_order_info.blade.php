<div class="card">
    <div class="card-header pb-0">
        <h5>Chi tiết</h5>
    </div>
    <div class="card-body pt-2">
        <div class="text-center">
            <img class="d-inline product-img mx-1" src="{{ $order->shipping_order->shipping_service->logo_address }}">
            <b>{{ $order->shipping_order->code }}</b>
        </div>
    </div>
    <div class="card-header">
        <h6>Thông tin lấy hàng</h6>
        <div style="background: #f4f4f4" class="d-flex justify-content-between align-items-center border rounded">
            <div class="row px-3 pt-1">
                <div class="col-5">
                    <b>Vận chuyển</b>
                    <br>
                    <span>{{ $order->shipping_order->shipping_service->name }}</span>
                </div>
                <div class="col-6">
                    <b>Lưu ý</b>
                    <br>
                    <span></span>
                </div>
                <div class="col-5">
                    <b>Ngày</b>
                    <br>
                    <span>{{ $order->shipping_order->estimated_pick_time->format('d/m/Y') }}</span>
                </div>
                <div class="col-6">
                    <b>{{ trans('labels.pickup_address') }}</b>
                    <br>
                    <p>
                        {{ $order->pickup_address->fullname }} <br>
                        {{ $order->pickup_address->phone }} <br>
                        {{ $order->pickup_address->full_address }} <br>
                        {{ $order->pickup_address->ward->name_with_type }} <br>
                        {{ $order->pickup_address->district->name_with_type }} <br>
                        {{ $order->pickup_address->province->name_with_type }} <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <a class="btn btn-primary" target="_blank" href="{{ route('admin.order.shipping_order.print', $order->id) }}">
                In phiếu giao
            </a>
        </div>
    </div>
</div>
