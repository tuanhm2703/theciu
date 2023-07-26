@extends('admin.layouts.app')
@push('style')
    <style>
        .video-js {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.rank')])
    <div class="container-fluid">
            <div class="card">
                <h6 class="card-header d-flex justify-content-between">
                    {{ trans('labels.rank_list') }}
                    <a class="btn btn-primary ajax-modal-btn" href="javascript:void(0)" data-init-app="false"
                        data-modal-size="modal-xl" data-link="{{ route('admin.review.setting.voucher') }}">
                        <i class="far fas fa-cog me-1"></i>Cài đặt review</a>
                </h6>
                <div class="card-body">
                    <table class="review-table table">
                        <thead>
                            <th>No.</th>
                            <th>{{ __('labels.customer') }}</th>
                            <th>{{ __('labels.status') }}</th>
                            <th>{{ __('labels.reply') }}</th>
                            <th>{{ __('labels.details') }}</th>
                            <th>{{ __('labels.action') }}</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        let table = $('.review-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.review.paginate') }}",
            "columns": [{
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const info = table.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: "customer.full_name"
                },
                {
                    data: 'status'
                },
                {
                    data: 'reply',
                    sortable: false,
                    searchable: false
                },
                {
                    data: "details",
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
