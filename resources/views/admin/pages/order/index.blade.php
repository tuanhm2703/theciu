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
            <ul class="nav nav-tabs" id="order-status-tab" role="tablist">
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
            </ul>
            <div class="tab-content">
                <div class="tab-pane active mt-3" id="order-sub-list" role="tabpanel">
                    <ul class="nav nav-tabs mb-3 d-none" id="sub-status-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="order-sub-list-tab" data-toggle="tab" href="#order-sub-list"
                                role="tab" data-order-sub-status="{{ App\Enums\OrderSubStatus::PREPARING }}"
                                aria-controls="order-sub-list" aria-selected="true">Chưa xử lý</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="order-sub-list-tab" data-toggle="tab" href="#order-sub-list"
                                role="tab" data-order-sub-status="{{ App\Enums\OrderSubStatus::FINISH_PACKAGING }}"
                                aria-controls="order-sub-list" aria-selected="true">Đã xử lý</span></a>
                        </li>
                    </ul>
                    <div class="text-end">
                        <button class="btn btn-primary ajax-modal-btn d-none" id="batch-finish-batching-btn"
                            data-get-data-function="getOrderId()"
                            data-link="{{ route('admin.order.batch.finish_packaging') }}">Đóng gói hàng loạt</button>
                    </div>
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
        const getOrderId = () => {
            return {
                order_ids: $('input[name="orderListItem[]"]:checked').map(function() {
                    return $(this).val()
                }).get()
            };
        }
        let inited = false;
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const orderStatus = $(e.target).data('orderStatus')
            $('#batch-finish-batching-btn').addClass('d-none')
            if (orderStatus != null) {
                $('#sub-status-tab').addClass('d-none')
                if (orderStatus == `{{ App\Enums\OrderStatus::WAITING_TO_PICK }}`) {
                    $('#sub-status-tab').removeClass('d-none')
                    const subStatus = $('#sub-status-tab a.active').attr('data-order-sub-status')
                    if (subStatus == `{{ App\Enums\OrderSubStatus::PREPARING }}`) {
                        $('#batch-finish-batching-btn').removeClass('d-none')
                    }
                    initOrderTable(orderStatus, subStatus)
                } else {
                    initOrderTable(orderStatus)
                }
            } else {
                const orderStatus = $('#order-status-tab a.active').attr('data-order-status');
                const subStatus = $('#sub-status-tab a.active').attr('data-order-sub-status')
                if (subStatus == `{{ App\Enums\OrderSubStatus::PREPARING }}`) {
                    $('#batch-finish-batching-btn').removeClass('d-none')
                }
                initOrderTable(orderStatus, subStatus)
            }
        });
        let orderTable;
        const initOrderTable = (order_status, order_sub_status = null) => {
            orderTable = $('.order-table').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": `{{ route('admin.ajax.order.paginate') }}?order_status=${order_status}${order_sub_status ? `&order_sub_status=${order_sub_status}` : ''}`,
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
                    if (inited === true) {
                        setTimeout(() => {
                            initStyleTable()
                        }, 50);
                    }
                }
            })
        }
        const initStyleTable = () => {
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
        $('body').on('click', '#submit-action-btn', (e) => {
            $('.status-label').html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
            )
            const orderIds = getOrderId().order_ids
            let totalFinished = 0;
            $(`#submit-action-btn`).loading()
            orderIds.forEach((id) => {
                $.ajax({
                    url: `/admintheciu/order/${id}/accept`,
                    type: 'PUT',
                    success: (res) => {
                        const total = totalFinished + 1;
                        if (total > totalFinished) {
                            totalFinished = total
                        }
                        $(`div[data-order-id=${id}]`).html(
                            `<i class="text-success fas fa-check-circle"></i>`
                        )
                        if (totalFinished == orderIds.length) {
                            toast.success(`{{ trans('toast.action_successful') }}`,
                                'Thao tác thành công')
                            orderTable.ajax.reload()
                            setTimeout(() => {
                                $('.modal.show').modal('hide')
                            }, 1000);
                        }
                    },
                    error: (err) => {
                        const total = totalFinished + 1;
                        if (total > totalFinished) {
                            totalFinished = total
                        }
                        if (totalFinished == orderIds.length) {
                            toast.success(`{{ trans('action_successful') }}`,
                                'Thao tác thành công')
                            orderTable.ajax.reload()
                            setTimeout(() => {
                                $('.modal.show').modal('hide')
                            }, 1000);
                        }
                        $(`div[data-order-id=${id}]`).html(
                            `<i class="text-danger fas fa-times-circle"></i>`
                        )
                    }
                })
            });
        })
    </script>
@endpush
