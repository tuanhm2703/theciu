@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.rank')])
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <h6 class="card-header d-flex justify-content-between">
                    {{ trans('labels.rank_list') }}
                    <a class="btn btn-primary ajax-modal-btn" href="javascript:void(0)" data-init-app="false"
                        data-modal-size="modal-md" data-link="{{ route('admin.rank.create') }}">
                        {{ trans('labels.create_rank') }}</a>
                </h6>
                <div class="card-body">
                    <table class="rank-table table">
                        <thead>
                            <th>No.</th>
                            <th>{{ trans('labels.name') }}</th>
                            <th>Benefit</th>
                            <th>Doanh thu tối thiểu</th>
                            <th>Hạn sử dụng</th>
                            <th>{{ trans('labels.action') }}</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            @include('admin.layouts.footers.auth.footer')
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        let table = $('.rank-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.rank.paginate') }}",
            "columns": [{
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const info = table.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: "name"
                },
                {
                    data: "benefit_value"
                },
                {
                    data: "min_value",
                },
                {
                    data: "cycle",
                },
                {
                    data: 'action',
                    sortable: false,
                    searchable: false
                }
            ],
            initComplete: function(settings, json) {
                $("[data-bs-toggle=tooltip]").tooltip({
                    html: true
                });
            }
        });
    </script>
@endpush
