@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.product_category')])
@push('style')
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
                                data-callback="setNullParentId()" data-init-app="false" data-modal-size="modal-sm"
                                data-link="{{ route('admin.category.product.create') }}"><i class="fas fa-plus"></i>
                                Tạo danh mục gốc</a>
                        </div>
                    </div>
                    <div class="col-md-8 right-side pe-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex category-wrapper d-none">
                                <h5 class="mb-0 d-flex align-items-center">Danh mục:&nbsp;<span id="category-title"></span>
                                </h5>
                                <a data-init-app="false" class="ms-3 ajax-modal-btn update-category-btn"
                                    href="javascript:;"><i class="fas fa-edit"></i></a>
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
            $.getJSON(`{{ route('admin.ajax.category.all', ['type' => App\Enums\CategoryType::PRODUCT]) }}`, (data) => {
                categories = data.data.data;
                categories.forEach(c1 => {
                    c1.text = `${c1.name} (${c1.categories.length})`
                    c1.nodes = c1.categories
                    c1.nodes.forEach(c2 => {
                        c2.text = `${c2.name} (${c2.categories.length})`
                    });
                });
                $('.treeview').treeview({
                    data: categories,
                    showTags: true,
                    levels: 3,
                    expandIcon: 'fas fa-plus opacity-6',
                    collapseIcon: 'fas fa-minus opacity-6',
                    onhoverColor: '#F5F5F5',
                    selectedColor: '#FFFFFF',
                    selectedBackColor: '#fb6340',
                    searchResultColor: '#D9534F',
                    onNodeSelected: function(event, data) {
                        if (data.categories) {
                            initChildCategoryTable(data.id)
                            parentId = data.id
                        }
                    }
                })
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
