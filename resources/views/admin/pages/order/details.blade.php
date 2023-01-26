@extends('admin.layouts.app')
@push('style')
    <style>
        .card-body {
            padding-left: 2.5rem !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.order_details')])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0">
                <h6>
                    <i class="opacity-6 fas fa-clipboard-list text-danger" aria-hidden="true"></i>
                    {{ $order->getCurrentStatusLabel() }}
                </h6>
            </div>
            <div class="card-body pt-0">
                <i>Đơn hàng đang chờ được xác nhận, vui lòng xác nhận đơn hàng.</i>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h6>
                    <i class="opacity-6 fas fa-history text-danger"></i>
                    Lịch sử mua hàng của người mua
                </h6>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-8">
                        <p>Với người mua có tỉ lệ giao hàng thành công thấp, hãy liên hệ xác nhận đơn hàng với họ trước khi
                            gửi hàng</p>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header pb-0">
                <h6>
                    <i class="fas fa-hashtag opacity-6 text-danger"></i>
                    Mã đơn hàng
                </h6>
            </div>
            <div class="card-body pt-0">
                <p>{{ $order->order_number }}</p>
            </div>
            <div class="card-header py-0">
                <h6>
                    <i class="fas fa-map-marker-alt text-danger opacity-6"></i>
                    Địa chỉ nhận hàng
                </h6>
            </div>
            <div class="card-body pt-0">
                <p>
                    {{ $order->shipping_address->fullname }}, {{ $order->shipping_address->phone }}<br>
                    {{ $order->shipping_address->full_address }}
                </p>
            </div>
            <div class="card-header py-0">
                <h6>
                    <i class="fas fa-truck opacity-6 text-danger"></i>
                    Thông tin vận chuyển
                </h6>
            </div>
            <div class="card-body pt-0">
                <p><span class="text-bold">Kiện hàng:</span>
                    <span>{{ $order->shipping_order->code ? $order->shipping_order->getShipServiceName() . ': ' : '' }}</span>
                    <span>{{ $order->shipping_service->name }}</span>
                    <span class="text-white bg-success px-1 py-1">{{ $order->shipping_order->code }}</span>
                </p>

                @foreach ($order->inventories as $inventory)
                    <div class="d-flex px-2 py-1">
                        <a href="{{ optional($inventory->image)->path_with_domain }}"
                            class="magnifig-img product-img img-thumbnail mx-1"
                            style="background: url({{ optional($inventory->image)->path_with_domain }})"></a>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $inventory->pivot->title }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ trans('labels.product_sku') }}:
                                {{ $inventory->sku }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@endpush
