@extends('admin.layouts.app')
@push('style')
    <style>
        .card-body {
            padding-left: 2.5rem !important;
        }

        .select2-container {
            width: 100% !important;
        }
        .timeline:before {
            border-right: none;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.order_details')])
    <div class="container-fluid row d-flex" style="align-content: stretch">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>
                        <i class="opacity-6 order-label-icon pe-1 fas fa-clipboard-list text-danger" aria-hidden="true"></i>
                        {{ $order->getCurrentStatusLabel() }}
                    </h6>
                </div>
                <div class="card-body pt-0">
                    @include('admin.pages.order.components.details.order_status_description')
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h6>
                        <i class="opacity-6 order-label-icon pe-1 fas fa-history text-danger"></i>
                        Lịch sử mua hàng của người mua
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-6 border-end">
                            <p>Với người mua có tỉ lệ giao hàng thành công thấp, hãy liên hệ xác nhận đơn hàng với họ trước
                                khi
                                gửi hàng</p>
                        </div>
                        <div class="col-6">
                            <div class="d-flex">
                                <div style="min-width: 70px; max-width: 30%">
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px; background: #f1f1f1; border-radius: 50px">
                                        <span class="text-danger text-bold text-sm">{{ $order_success_percentage }}%</span>
                                    </div>
                                </div>
                                <div class="text-sm align-items-center">
                                    @if ($order->customer->canceled_orders()->count() == 0 && $total_delivered_orders == 0)
                                        <span>Khách hàng chưa có đơn hàng nào</span>
                                    @else
                                        <span>Đơn giao thành công</span> <br>
                                        > <span class="text-success">{{ $total_delivered_orders }}</span> tổng đơn giao
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header pb-0">
                    <h6>
                        <i class="fas fa-hashtag opacity-6 order-label-icon pe-1 text-danger"></i>
                        Mã đơn hàng
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <p>{{ $order->order_number }}</p>
                </div>
                <div class="card-header py-0">
                    <h6>
                        <i class="fas fa-map-marker-alt text-danger opacity-6 order-label-icon pe-1"></i>
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
                        <i class="fas fa-truck opacity-6 order-label-icon pe-1 text-danger"></i>
                        Thông tin vận chuyển
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <p><span class="text-bold">Kiện hàng:</span>
                        <span>{{ $order->shipping_order->code ? $order->shipping_order->getShipServiceName() . ': ' : '' }}</span>
                        <span>{{ $order->shipping_service->name }}</span>
                        @if (!empty($order->shipping_order->code))
                            <span class="text-white bg-success px-1 py-1">{{ $order->shipping_order->code }}</span>
                        @endif
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
        </div>
        <div class="col-lg-3">
            <div class="card h-100">
                <div class="card-header">

                </div>
                <div class="card-body p-0" style="padding-left: 0 !important">
                    <div class="d-flex align-items-center px-2">
                        <div class="bg-light" style="width: 100%; height: 1px"></div>
                        <div class="text-uppercase bg-white position-absolute text-sm" style="left: 50%;
                                                                                transform: translate(-50%);
                                                                                width: max-content;
                                                                                padding: 0.5rem;">Lịch sử đơn hàng</div>
                    </div>
                    <div class="mt-3 p-3">
                        @include('admin.pages.order.components.details.order_timeline')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        $('.update-order-status-form').ajaxForm({
            beforeSend: () => {
                $('.update-order-status-form input[type=submit]').loading()
            },
            success: (res) => {
                tata.success(@json(trans('toast.action_successful')), res.data.message)
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            },
            error: (err) => {
                tata.error(@json(trans('toast.action_failed')), err.responseJSON.message)
                $('.update-order-status-form input[type=submit]').loading(false)
            }
        })
    </script>
@endpush
