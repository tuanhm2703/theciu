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
                        data-order-status="{{ App\Enums\OrderStatus::ALL }}" aria-controls="order-list"
                        aria-selected="true">Tất cả <span class="order-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        data-order-status="{{ App\Enums\OrderStatus::WAIT_TO_ACCEPT }}" aria-controls="order-list"
                        aria-selected="true">Chờ xác nhận <span class="order-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        data-order-status="{{ App\Enums\OrderStatus::WAITING_TO_PICK }}" aria-controls="order-list"
                        aria-selected="true">Chờ lấy hàng <span class="order-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        data-order-status="{{ App\Enums\OrderStatus::PICKING }}" aria-controls="order-list"
                        aria-selected="true">Đang lấy hàng <span class="order-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        data-order-status="{{ App\Enums\OrderStatus::DELIVERING }}" aria-controls="order-list"
                        aria-selected="true">Đang giao <span class="order-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        data-order-status="{{ App\Enums\OrderStatus::DELIVERED }}" aria-controls="order-list"
                        aria-selected="true">Đã giao <span class="order-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        data-order-status="{{ App\Enums\OrderStatus::CANCELED }}" aria-controls="order-list"
                        aria-selected="true">Đơn huỷ <span class="order-count"></span></a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                        aria-controls="order-list" aria-selected="true">Trả hàng/Hoàn tiền</a>
                </li> --}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active mt-3" id="order-list" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table order-table w-100">
                            <thead>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Đơn vị vận chuyển</th>
                                    <th>Thời gian tạo</th>
                                    <th>Ngày giao hàng</th>
                                    <th>Thao tác</th>
                                    <th></th>
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
        let inited = false;
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const orderStatus = $(e.target).data('orderStatus')
            initOrderTable(orderStatus)
        });
        let orderTable;
        const initOrderTable = (order_status) => {
            orderTable = $('.order-table').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": `{{ route('admin.ajax.order.paginate') }}?order_status=${order_status}`,
                "columns": [{
                        data: "header",
                        className: 'order-header-column',
                    },
                    {
                        data: "items",
                    },
                    {
                        data: "subtotal",
                        width: '10'
                    },
                    {
                        data: "status",
                    },
                    {
                        data: 'shipping_service'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'delivery_date',
                    },
                    {
                        data: 'action'
                    },
                    {
                        data: 'order_number',
                        visible: false
                    }
                ],
                order: [
                    [5, 'desc']
                ],
                initComplete: function(settings, json) {
                    json.order_counts.forEach(data => {
                        $(`[data-order-status=${data.order_status}] .order-count`).text(
                            `(${data.order_count})`)
                    })
                    if ($("[data-bs-toggle=tooltip]").length) {
                        $("[data-bs-toggle=tooltip]").tooltip({
                            html: true
                        });
                    }
                    initStyleTable()
                },
                drawCallback: function(settings) {
                    if(inited === true) {
                        console.log('hello');
                        setTimeout(() => {
                            initStyleTable()
                        }, 50);
                    }
                }
            })
        }
        const initStyleTable = () => {
            console.log($('.order-header-column').length);
            $('.order-header-column').each((index, e) => {
                const header = $(e).clone()
                if (index > 0 || (inited == true && index == 0)) {
                    $(`<tr class="order-header-row"><td colspan="8">
                                ${$(header).html()}
                            </td></tr>`).insertBefore($(e).parents('tr'))
                }
            })
            $('.order-header-column').remove()
            $('.order-header-row').each((index, e) => {
                if ($(e).find('.customer-info-wrapper').length == 0) {
                    $(e).remove()
                }
            })
            inited = true
        }
        initOrderTable(@json(App\Enums\OrderStatus::ALL))
    </script>
@endpush
