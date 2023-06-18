@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.product')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.product_list') }}</h6>
                    <div class="dropdown">
                        <a href="#" class="btn dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                            Công cụ Xử lý hàng loạt
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            <li>
                                {{-- <a class="dropdown-item ajax-modal-btn" href="javascript:void(0)" data-init-app="false"
                                    data-link="{{ route('admin.ajax.product.views.batch_create') }}">
                                    Đăng sản phẩm hàng loạt
                                </a> --}}
                                <a class="dropdown-item ajax-modal-btn" href="javascript:void(0)" data-modal-size="modal-xl"
                                    data-link="{{ route('admin.ajax.product.views.batch_update') }}">
                                    Cập nhật sản phẩm hàng loạt
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <ul class="nav nav-tabs" id="product-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab"
                            data-product-type="{{ App\Enums\ProductType::ALL }}" aria-controls="order-list"
                            aria-selected="true">Tất cả <span class="order-count"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="out-of-stock-tab" data-toggle="tab" href="#out-of-stock" role="tab"
                            data-product-type="{{ App\Enums\ProductType::OUT_OF_STOCK }}" aria-controls="order-list"
                            aria-selected="true">Hết hàng <span class="order-count"></span></a>
                    </li>
                </ul>
                <div class="table-responsive p-3">
                    <div class="tab-content">
                        <div class="tab-pane active mt-3" role="tabpanel">
                            <table class="product-table table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            {{ trans('labels.product_name') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-2">
                                            Mã sản phẩm</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-2">
                                            {{ trans('labels.classify_sku') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            {{ trans('labels.category') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            {{ trans('labels.price') }}</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                            {{ trans('labels.warehouse') }}</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                            {{ trans('labels.sales') }}</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                            {{ trans('labels.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="form-check text-center form-check-info">
                                    <input type="checkbox" name="mass-checkbox-btn"
                                        class="editor-active form-check-input mass-checkbox-btn">
                                        <label for="mass-checkbox-btn">Chọn tất cả</label>
                                </div>
                                <button class="btn btn-default" id="massDeleteBtn"><i class="far fa-trash-alt me-2" aria-hidden="true"></i> Xoá</button>
                            </div>
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
        const initProductTable = (productType = `{{ App\Enums\ProductType::ALL }}`) => {
                $('.product-table tbody').html('')
                return $('.product-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "ajax": `{{ route('admin.ajax.product.paginate') }}?product_type=${productType}`,
                    "columns": [{
                            data: "updated_at",
                            visible: false,
                        },
                        {
                            data: "checkbox",
                            sortable: false,
                            searchable: false
                        },
                        {
                            data: "name"
                        },
                        {
                            data: "id"
                        },
                        {
                            data: "inventory_sku"
                        },
                        {
                            data: "attribute_description",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "price_info",
                            orderable: false,
                            name: 'inventories.price'
                        },
                        {
                            data: 'quantity_info',
                            orderable: false,
                            name: 'inventories.stock_quantity'
                        },
                        {
                            data: 'sales',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'actions',
                            orderable: false,
                            searchable: false,
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    initComplete: function(settings, json) {
                        $('.magnifig-img').magnificPopup({
                            type: "image",
                        });
                        $('.ajax-form-confirm').ajaxForm({
                            success: (res) => {
                                table.ajax.reload()
                            }
                        })
                    }
                });
            }
        let table = initProductTable()
        $('#product-tab .nav-link').on('click', function() {
            initProductTable($(this).attr('data-product-type'))
        })
        $('#massDeleteBtn').on('click', function() {
            $(this).loading()
            const productIds = $('.child-checkbox:checked').map(function() {
                return $(this).attr('data-product-id');
            }).get()
            $.ajax({
                url: `{{ route('admin.product.delete.mass') }}`,
                type: 'DELETE',
                data: {
                    product_ids: productIds
                },
                error: (err) => {
                    $(this).loading(false)
                },
                success: (res) => {
                    initProductTable($('#product-tab .nav-link.active').attr('data-product-id'))
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    table.ajax.reload()
                    $(this).loading(false)
                }
            })
        })
        $(document).on('click', '.mass-checkbox-btn', (e) => {
            $('.product-table').children('tbody').find('.child-checkbox').prop('checked', $(e.target).is(':checked'))
        })
    </script>
@endpush
