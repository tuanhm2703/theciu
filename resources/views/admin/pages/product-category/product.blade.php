@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.product_category')])
@push('style')
    <style>
        .gj-tree-bootstrap-5 ul.gj-list-bootstrap li.active {
            background-color: #fb6340 !important;
        }
        .gj-tree-bootstrap-5 ul.gj-list-bootstrap li.active i {
            color: #fff;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.product_category')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.product_category') }}</h6>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-md-4">
                        <div class="treeview mx-3">
                        </div>
                        <div class="text-end mx-3 mt-3">
                            <a class="btn btn-primary btn-sm ms-auto ajax-modal-btn" href="javascript:;"
                                data-callback="setNullParentId()" data-init-app="false" data-modal-size="modal-md"
                                data-link="{{ route('admin.category.product.create') }}">
                                <i class="fas fa-plus"></i>
                                Tạo danh mục gốc
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 right-side pe-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex category-wrapper d-none">
                                <h5 class="mb-0 d-flex align-items-center">Danh mục:&nbsp;<span id="category-title"></span>
                                </h5>
                                <a class="ms-3 ajax-modal-btn update-category-btn" href="javascript:;"><i
                                        class="fas fa-edit"></i></a>
                            </div>
                            <a class="btn btn-primary btn-sm ms-auto ajax-modal-btn" href="javascript:;"
                                data-init-app="false" data-link="{{ route('admin.category.product.create') }}"><i
                                    class="fas fa-plus"></i>
                                {{ trans('labels.create_category') }}</a>
                        </div>
                        <table class="category-table table">
                            <thead>
                                <tr>
                                    <td>
                                        No.
                                    </td>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                        {{ trans('labels.category_name') }}</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-2">
                                        {{ trans('labels.product') }}</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                        {{ trans('labels.on/of') }}</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                        {{ trans('labels.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        let categoryTable;
        let parentId;
        let categories;
        const initTreeview = () => {
            const tree = $('.treeview').tree({
                uiLibrary: 'bootstrap5',
                dataSource: `{{ route('admin.ajax.category.all', ['types' => serialize([App\Enums\CategoryType::PRODUCT, App\Enums\CategoryType::COLLECTION])]) }}`,
                primaryKey: 'id',
            })
            tree.on('select', function (e, node, id) {
                initChildCategoryTable(id)
            });
            $('.treeview').sortable({
                update: (event, ui) => {
                    const ids = []
                    $('.gj-list:first-child > .list-group-item').each(function(i, e) {
                        ids.push($(e).attr('data-id'))
                    })
                    updateOrder(ids)
                },
                items: '.gj-list:first-child > .list-group-item'
            })
        }
        const updateOrder = (ids) => {
            $.ajax({
                url: `{{ route('admin.ajax.category.order.update') }}`,
                type: 'PUT',
                data: {
                    ids: ids
                },
                success: (res) => {
                    toast.success(@json(trans('toast.action_successful')), res.data.message)
                }
            })
        }
        const initChildCategoryTable = (parentId) => {
            categoryTable = $('.category-table').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": `{{ route('admin.ajax.category.product.paginate') }}?parentId=${parentId}&type={{ App\Enums\CategoryType::PRODUCT }}`,
                "columns": [{
                        data: 'name',
                        render: function(data, type, full, meta) {
                            const info = categoryTable.page.info()
                            const rowNumber = meta.row + 1;
                            return (info.page) * info.length + rowNumber

                        }
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "products_count"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "action"
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                initComplete: function(settings, json) {
                    let category = json.category
                    $('.category-wrapper').removeClass('d-none');
                    $('#category-title').text(category.name)
                    $('.update-category-btn').attr('data-link', category.edit_url)
                }
            });
        }
        const setNullParentId = () => {
            parentId = null
        }
        initTreeview()
    </script>
@endpush
