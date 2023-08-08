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

        .shipping-history-timeline {
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .timeline-closed {
            height: 66px;
        }

        #expan-timeline-btn {
            position: absolute;
            top: 0;
            right: 10px;
            cursor: pointer;
        }

        .order-turnover-info .turnover-label:first-child {
            border-top: 1px solid #DEE2E5;
            border-top-style: dashed;
        }

        .order-turnover-info .turnover-label {
            border-right: 1px solid #DEE2E5;
            border-right-style: dashed;
        }

        .customer-payment-info {
            border-top: 1px solid #DEE2E5;
            text-align: right;
        }

        .customer-payment-info .payment-info-label {
            border-right: 1px solid #DEE2E5;
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
                        <i class="fas fa-sticky-note text-danger opacity-6 order-label-icon pe-1"></i>Chú thích đơn hàng
                    </h6>
                </div>
                <div class="card-body pt-1">
                    <i>{{ $order->note }}</i>
                    <div class="text-danger"><i>{{ $order->bonus_note }}</i></div>
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
                    <div class="mt-3 ms-2">
                        @include('admin.pages.order.components.details.shipping_order_timeline')
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header pb-0">
                    <h6>
                        <svg width="20px" style="fill: #f5365c !important" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;"
                            xml:space="preserve">
                            <path
                                d="M27.8,27.1H8.5c-1,0-1.8-0.8-1.8-1.8v-1.8h1.8v0.9c0,0.5,0.4,0.9,0.9,0.9h17.6c0.5,0,0.9-0.4,0.9-0.9V12.2 c0-0.5-0.4-0.9-0.9-0.9H26v-0.9c0-0.5-0.4-0.9-0.9-0.9h2.6c1,0,1.8,0.8,1.8,1.8v14C29.6,26.3,28.8,27.1,27.8,27.1z M22.5,21.9H3.2 c-1,0-1.8-0.8-1.8-1.8v-14c0-1,0.8-1.8,1.8-1.8h19.3c1,0,1.8,0.8,1.8,1.8v14C24.3,21.1,23.5,21.9,22.5,21.9z M22.5,6.9 c0-0.5-0.4-0.9-0.9-0.9H4.1c-0.5,0-0.9,0.4-0.9,0.9v12.3c0,0.5,0.4,0.9,0.9,0.9h17.6c0.5,0,0.9-0.4,0.9-0.9V6.9z M15.5,14.9 c0,1.1-0.8,2.2-2.1,2.4v1.1h-1v-1.1c-1.4-0.2-2.2-1.1-2.2-1.1l0.8-1.1c0,0,0.9,0.9,1.9,0.9c0.6,0,1.1-0.4,1.1-1 c0-1.4-3.7-1.2-3.7-3.7c0-1.2,0.9-2.1,2.1-2.3V7.8h1v1.1c1.3,0.1,1.9,0.9,1.9,0.9L14.8,11c0,0-0.8-0.7-1.8-0.7c-0.7,0-1.1,0.4-1.1,1 C11.8,12.6,15.5,12.4,15.5,14.9z">
                            </path>
                        </svg>
                        Thông tin thanh toán
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row bg-light">
                        <div class="col-1">STT</div>
                        <div class="col-5">
                            Sản phẩm
                        </div>
                        <div class="col-2">
                            Đơn giá
                        </div>
                        <div class="col-2">Số lượng</div>
                        <div class="col-2">Thành tiền</div>
                    </div>
                    <div class="row d-flex align-items-center">
                        @foreach ($order->inventories as $index => $item)
                            <div class="col-1">{{ $index + 1 }}</div>
                            <div class="col-5">
                                <div class="d-flex px-2 py-1">
                                    <a href="{{ optional($item->image)->path_with_domain }}"
                                        class="magnifig-img product-img img-thumbnail mx-1"
                                        style="background: url({{ optional($item->image)->path_with_domain }})"></a>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm" style="line-height: 1rem">{{ $item->pivot->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ trans('labels.product_sku') }}:
                                            {{ $inventory->sku }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                {{ format_currency_with_label($item->pivot->promotion_price) }}
                            </div>
                            <div class="col-2">
                                {{ $item->pivot->quantity }}
                            </div>
                            <div class="col-2">
                                {{ format_currency_with_label($item->pivot->total) }}
                            </div>
                        @endforeach
                        <div class="row text-end order-turnover-info">
                            <div class="col-10 turnover-label">
                                <b>Tổng tiền sản phẩm</b>
                            </div>
                            <div class="col-2">
                                <b>{{ format_currency_with_label($order->subtotal) }}</b>
                            </div>
                            @if ($order->order_voucher)
                                <div class="col-10 turnover-label">
                                    <span>Mã giảm giá</span>
                                </div>
                                <div class="col-2">
                                    - {{ format_currency_with_label($order->order_voucher->pivot->amount) }}
                                </div>
                            @endif
                            {{-- <div class="col-10 turnover-label">
                                <b>Phí vận chuyển (không tính trợ giá)</b>
                            </div>
                            <div class="col-2">
                                <b>{{ format_currency_with_label($order->shipping_order->total_fee) }}</b>
                            </div> --}}
                            <div class="col-10 turnover-label">
                                <span>Phí vận chuyển người mua trả</span>
                            </div>
                            <div class="col-2">
                                @if ($order->freeship_voucher)
                                    <span class="text-decoration-line-through">{{ format_currency_with_label($order->shipping_fee) }}</span>
                                    <span>{{ format_currency_with_label($order->customer_shipping_fee_amount) }}</span>
                                @else
                                    <span>{{ format_currency_with_label($order->customer_shipping_fee_amount) }}</span>
                                @endif
                            </div>
                            <div class="col-10 turnover-label">
                                <span>Phí vận chuyển thực tế</span>
                            </div>
                            <div class="col-2">
                                <span> {{ format_currency_with_label($order->getActualShippingFee()) }}</span>
                            </div>
                            <div class="col-10 turnover-label">
                                <span>{{ trans('labels.discount_for_member') }}</span>
                            </div>
                            <div class="col-2">
                                <span> - {{ format_currency_with_label($order->rank_discount_value) }}</span>
                            </div>
                            <div class="col-10 turnover-label">
                                <b>Doanh thu đơn hàng</b>
                            </div>
                            <div class="col-2">
                                <h5 class="text-danger">
                                    {{ format_currency_with_label($order->getFinalRevenue()) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header pb-0">
                    <h6><svg width="20px" style="fill: #f5365c !important" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16">
                            <path
                                d="M3,9.73900507 C3.2974736,9.73900507 3.56460998,9.86889415 3.74778815,10.0750513 L3.8167343,10.1618497 C4.19264814,9.99957946 4.66721129,9.94970609 5.27118152,10.0054776 L5.68637932,10.0517782 L5.90416692,10.0704924 L6.16572915,10.0877345 L7.80947591,10.1681168 L8.20107172,10.1942369 L8.54363555,10.2244474 L8.85205991,10.2605268 C10.0462245,10.4201416 10.3457878,11.5706438 9.74428704,12.171442 C9.9548482,12.1941441 10.170558,12.1821817 10.3821475,12.1350413 L10.5399223,12.0930822 L13.4762645,11.1830009 C13.8899084,11.0547973 14.3362209,11.175581 14.6286936,11.4849155 L14.7116337,11.5833119 L14.778099,11.6860284 C14.9963457,12.0807152 14.8811036,12.5697349 14.5257815,12.828595 L14.4320033,12.8883273 L10.2544072,15.1983789 C9.74361287,15.4808287 9.15008315,15.5756492 8.57667773,15.4664094 L7.02175521,15.1779617 C5.97357895,14.9902732 5.3058654,14.8885555 5.04879107,14.8758273 L3.99084833,14.8748674 C3.92455844,15.3628864 3.50620284,15.7390051 3,15.7390051 L2,15.7390051 C1.44771525,15.7390051 1,15.2912898 1,14.7390051 L1,10.7390051 C1,10.1867203 1.44771525,9.73900507 2,9.73900507 L3,9.73900507 Z M3,10.7390051 L2,10.7390051 L2,14.7390051 L3,14.7390051 L3,10.7390051 Z M4.07323766,11.1581709 L4,11.2130051 L4,13.8740051 L5.06295563,13.8758733 L5.24291423,13.8889306 C5.41678047,13.9055298 5.65065601,13.9364502 5.94647174,13.9818849 L6.54625254,14.0793846 L7.20971299,14.1954365 L8.76384423,14.4840812 C9.05874116,14.5402622 9.36251502,14.5064883 9.63629126,14.3889693 L9.7704996,14.3232598 L13.6580677,12.1735827 L10.8359662,13.0482565 C10.0204955,13.3010011 9.13955438,13.1946753 8.41076405,12.7627297 L8.267,12.6700051 L7.92554649,12.7236708 C7.57482452,12.7744432 7.1976821,12.8175869 6.79395614,12.8532174 C6.51888293,12.8774937 6.2762122,12.6741826 6.25193589,12.3991094 C6.22765958,12.1240362 6.43097065,11.8813654 6.70604386,11.8570891 C7.59157993,11.7789371 8.33292848,11.6640512 8.92806509,11.5138608 C9.11860405,11.4657759 9.10806456,11.3036383 8.71957588,11.251712 L8.43582923,11.2186776 L8.11465335,11.1905946 C7.99987851,11.1818899 7.87664846,11.1737567 7.74274617,11.1659416 L6.09055504,11.0850987 L5.69325145,11.0567852 L5.17133556,11.0003395 C4.60649935,10.94812 4.26975585,11.0128809 4.07323766,11.1581709 Z M8.5,0.260994928 C10.9852814,0.260994928 13,2.27571355 13,4.76099493 C13,7.2462763 10.9852814,9.26099493 8.5,9.26099493 C6.01471863,9.26099493 4,7.2462763 4,4.76099493 C4,2.27571355 6.01471863,0.260994928 8.5,0.260994928 Z M8.5,1.26099493 C6.56700338,1.26099493 5,2.8279983 5,4.76099493 C5,6.69399155 6.56700338,8.26099493 8.5,8.26099493 C10.4329966,8.26099493 12,6.69399155 12,4.76099493 C12,2.8279983 10.4329966,1.26099493 8.5,1.26099493 Z M8.28801303,1.97193243 L8.78773335,1.97339076 L8.78481953,2.53630743 C9.45936912,2.60047409 9.80611384,2.98693243 9.80611384,2.98693243 L9.47685205,3.62714076 L9.40730733,3.5678504 C9.27242929,3.46107305 8.95418538,3.24724493 8.56628294,3.24505743 C8.21808132,3.24359909 7.94272522,3.45651576 7.94126831,3.76276576 C7.93835449,4.49047409 9.8978992,4.36943243 9.89209745,5.73880743 C9.89209745,6.36151576 9.47685205,6.89234909 8.7673366,6.98714076 L8.76442278,7.55005743 L8.26470246,7.54859909 L8.26761628,6.98568243 C7.51730733,6.89089076 7.10791546,6.40526576 7.10791546,6.40526576 L7.51730733,5.81318243 L7.58453941,5.87531858 C7.72976628,6.00089323 8.09614911,6.27323051 8.54442929,6.27547409 C8.85912197,6.27839076 9.14321953,6.10776576 9.14467644,5.75193243 C9.14759026,5.01693243 7.1822179,5.08401576 7.18804555,3.77005743 C7.19095937,3.13859909 7.63968782,2.65151576 8.2850992,2.54505743 L8.28801303,1.97193243 Z">
                            </path>
                        </svg> Thanh toán của Người mua</h6>
                </div>
                <div class="card-body">
                    <div class="row customer-payment-info">
                        <div class="col-10 payment-info-label ">
                            <span>Tổng tiền sản phẩm</span>
                        </div>
                        <div class="col-2">
                            <span>{{ format_currency_with_label($order->subtotal) }}</span>
                        </div>
                        <div class="col-10 payment-info-label">
                            <span>Phí vận chuyển</span>
                        </div>
                        <div class="col-2">
                            <span>{{ format_currency_with_label($order->shipping_order->total_fee) }}</span>
                        </div>
                        @if ($order->order_voucher)
                            <div class="col-10 payment-info-label">
                                <span>Mã giảm giá</span>
                            </div>
                            <div class="col-2">
                                <span>
                                    - {{ format_currency_with_label($order->order_voucher->pivot->amount) }}
                                </span>
                            </div>
                        @endif
                        @if ($order->freeship_voucher)
                            <div class="col-10 payment-info-label">
                                <span>Giảm giá vận chuyển</span>
                            </div>
                            <div class="col-2">
                                <span>
                                    - {{ format_currency_with_label($order->freeship_voucher->pivot->amount) }}
                                </span>
                            </div>
                        @endif
                        <div class="col-10 payment-info-label">
                            <span>{{ trans('labels.discount_for_member') }}</span>
                        </div>
                        <div class="col-2">
                            <span>
                                - {{ format_currency_with_label($order->rank_discount_value) }}
                            </span>
                        </div>
                        <div class="col-10 payment-info-label">
                            <span>Tổng tiền Thanh toán</span>
                        </div>
                        <div class="col-2">
                            <h5>{{ format_currency_with_label($order->total) }}</h5>
                        </div>
                    </div>
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
                        <div class="text-uppercase bg-white position-absolute text-sm"
                            style="left: 50%;
                                                                                transform: translate(-50%);
                                                                                width: max-content;
                                                                                padding: 0.5rem;">
                            Lịch sử đơn hàng</div>
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
                toast.success(@json(trans('toast.action_successful')), res.data.message)
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            },
            error: (err) => {
                tata.error(@json(trans('toast.action_failed')), err.responseJSON.message)
                $('.update-order-status-form input[type=submit]').loading(false)
            }
        })
        $('#expan-timeline-btn').on('click', (e) => {
            if ($('#expan-timeline-btn').hasClass('closed')) {
                $('#expan-timeline-btn').removeClass('closed')
                $('#expan-timeline-btn').html(`Thu nhỏ <i class="fas fa-chevron-up"></i>`)
                $('.shipping-history-timeline').removeClass('timeline-closed')
            } else {
                $('#expan-timeline-btn').addClass('closed')
                $('#expan-timeline-btn').html(`Mở rộng <i class="fas fa-chevron-down"></i>`)
                $('.shipping-history-timeline').addClass('timeline-closed')
            }
        })
    </script>
@endpush
