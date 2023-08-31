@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.page_list')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.page_list') }}</h6>
                    <a class="btn btn-primary"
                        href="{{ route('admin.page.create') }}">{{ trans('labels.create_page') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="p-3">
                    <table class="page-table table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.title') }}</th>
                                    <th>{{ trans('labels.position') }}</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-2">
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
        const table = $('.page-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.ajax.page.paginate') }}",
            "columns": [{
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const info = table.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: 'title'
                },
                {
                    data: 'order'
                },
                {
                    data: "action",
                    sortable: false,
                    searchable: false,
                    width: "10%"
                },
            ]
        });

        const iniPageFormCallback = () => {
            $('.page-form').ajaxForm({
                beforeSubmit: () => {
                    $('.page-form button[type=submit]').loading()
                },
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    $('.modal.show').modal('hide')
                    table.ajax.reload()
                },
                error: (err) => {
                    $('.page-form button[type=submit]').loading(false)
                }
            })
        }
    </script>
@endpush
