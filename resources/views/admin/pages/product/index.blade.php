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

                <div class="table-responsive p-3">
                    <table class="product-table table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th></th>
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
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const table = $('.product-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.ajax.product.paginate') }}",
            "columns": [
                {
                    data: "updated_at",
                    visible: false
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
            order: [[0, 'desc']],
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
    </script>
@endpush
