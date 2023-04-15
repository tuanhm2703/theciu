@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.customer_list')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.page_list') }}</h6>
                    <a class="ajax-modal-btn btn btn-primary" data-callback="iniPageFormCallback()"
                        data-link="{{ route('admin.page.create') }}">{{ trans('labels.create_page') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="p-3">
                    <table class="table align-items-center mb-0 customer-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="">
                                    {{ trans('labels.fullname') }}</th>
                                <th>{{ trans('labels.phone') }}</th>
                                <th>{{ trans('labels.email_address') }}</th>
                                <th>{{ trans('labels.number_of_orders') }}</th>
                                <th>{{ trans('labels.revenue') }}</th>
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
        const table = $('.customer-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.customer.paginate') }}",
            "columns": [
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const info = table.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: "full_name"
                },
                {
                    data: "phone"
                },
                {
                    data: "email"
                },
                {
                    data: "orders_count",
                },
                {
                    data: "total_revenue",
                },
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
    </script>
@endpush
