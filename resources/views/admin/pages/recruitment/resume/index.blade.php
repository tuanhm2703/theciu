@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
        .table.align-items-center td {
            vertical-align: text-top;
        }
        .table *:not(.badge) {
            font-size: 14px !important;
        }
        .info-description p>i{
            display: inline-block;
            width: 20px;
            text-align: center
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.jd_list')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.resume_list') }}</h6>
                    <a class="btn btn-primary" href="{{ route('admin.recruitment.jd.create') }}">{{ trans('labels.create_jd') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="p-3">
                   @include('admin.pages.recruitment.resume.components.table')
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const table = $('.resume-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.recruitment.resume.paginate') }}",
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
                    data: "candidate"
                },
                {
                    data: "jd.name",
                },
                {
                    data: "contact_info",
                },
                {
                    data: "insign",
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
