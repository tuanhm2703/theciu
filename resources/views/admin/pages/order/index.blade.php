@extends('admin.layouts.app')
@push('style')
    <style>
        .select2-container {
            width: 100% !important;
        }
        .order-shipping-info-label {
            display: flex;
        }
        .order-shipping-info-label label {
            width: 30%;
        }
        .order-shipping-info-label span {
            width: 70%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.order_list')])
    <div class="container-fluid">
        <x-admin.card header="{{ trans('nav.order_list') }}">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Tất cả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Chờ xác nhận</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Chờ lấy hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Đang giao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Đã giao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Đơn huỷ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Trả hàng/Hoàn tiền</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active mt-3" id="order-list" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table order-table w-100">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Trạng thái</th>
                                    {{-- <th>Đơn vị vận chuyển</th> --}}
                                    <th>Thời gian tạo</th>
                                    <th>Ngày giao hàng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </x-admin.card>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const orderTable = $('.order-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.ajax.order.paginate') }}",
            "columns": [{
                    data: "items",
                },
                {
                    data: "subtotal",
                },
                {
                    data: "status",
                },
                // {
                //     data: 'shipping_service'
                // },
                {
                    data: 'created_at'
                },
                {
                    data: 'delivery_date',
                },
                {
                    data: 'action'
                }
            ],
            initComplete: (settings, json) => {
                if ($("[data-bs-toggle=tooltip]").length) {
                    $("[data-bs-toggle=tooltip]").tooltip({
                        html: true
                    });
                }
            }
        })
    </script>
@endpush
