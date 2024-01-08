@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.jd_list')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.page_list') }}</h6>
                    <a class="btn btn-primary" href="{{ route('admin.recruitment.jd.create') }}">{{ trans('labels.create_jd') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="p-3">
                    <table class="table align-items-center mb-0 jd-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="">
                                    {{ trans('labels.job_name') }}</th>
                                <th>{{ trans('labels.department_group') }}</th>
                                <th>{{ trans('labels.job_type') }}</th>
                                <th>{{ trans('labels.time') }}</th>
                                <th>{{ trans('labels.number_of_resumes') }}</th>
                                <th>{{ trans('labels.action') }}</th>
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
        const table = $('.jd-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.recruitment.jd.paginate') }}",
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
                    data: "name",
                },
                {
                    data: "group"
                },
                {
                    data: "job_type"
                },
                {
                    data: "time",
                    name: 'created_at'
                },
                {
                    data: "resumes_count",
                },
                {
                    data: "action",
                },
            ],
            order: [
                [0, 'desc']
            ],
        });
    </script>
@endpush
