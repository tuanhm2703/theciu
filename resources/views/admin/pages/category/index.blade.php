@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.category')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.category_list') }}</h6>
                    <a class="btn btn-primary btn-sm ms-auto ajax-modal-btn" href="javascript:;" data-init-app="false"
                        data-link="{{ route('admin.ajax.category.view.create') }}"><i class="fas fa-plus"></i>
                        {{ trans('labels.create_category') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-3">
                    <table class="category-table table align-items-center mb-0">
                        <thead>
                            <tr>
                                <td>
                                    <div class="form-check text-center form-check-info">
                                        <input type="checkbox" class="editor-active form-check-input mass-checkbox-btn">
                                    </div>
                                </td>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.category_name') }}</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.category_type') }}</th>
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
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        $(document).on('change', '.category-status', function(e) {
            const status = $(this).is(':checked') ? 1 : 0
            const url = $(e.target).attr('data-submit-url')
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    status
                },
                success: (res) => {
                    tata.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                }
            })
        })
        const categoryTable = $('.category-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.ajax.category.paginate') }}",
            "columns": [{
                    data: "id",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return `<div class="form-check text-center form-check-info">
                                        <input type="checkbox" class="editor-active form-check-input child-checkbox">
                                    </div>`
                        }
                        return data;
                    },
                    className: "dt-body-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name"
                },
                {
                    data: "type"
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
            order: [[1, 'desc']],
        });
        categoryTable.rows((idx, data, node) => {
            return $('input[type=checkbox]').is(':checked');
        }).data();
    </script>
@endpush
