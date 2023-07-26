@extends('admin.layouts.app')
@push('style')
    <style>
        .video-js {
            width: 100% !important;
        }

        .review-products h6 {
            text-overflow: ellipsis !important;
            overflow: hidden !important;
            width: 200px !important;
            white-space: nowrap !important;
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
            <div class="card-body table-responsive">
                <table class="review-table table">
                    <thead>
                        <th>No.</th>
                        <th></th>
                        <th>Sản phẩm</th>
                        <th>{{ __('labels.status') }}</th>
                        <th>{{ __('labels.details') }}</th>
                        <th>{{ __('labels.reply') }}</th>
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
                    },
                    width: '5%'
                },
                {
                    data: 'created_at',
                    visible: false
                },
                {
                    data: 'products',
                    width: '10%'
                },
                {
                    data: 'status',
                    width: '7%'
                },
                {
                    data: "details",
                    width: "30%"
                },
                {
                    data: "reply",
                },
                {
                    data: 'action',
                    sortable: false,
                    searchable: false,
                    width: '5%'
                },
            ],
            order: [
                [1, 'desc']
            ],
            initComplete: function(settings, json) {
                $("[data-bs-toggle=tooltip]").tooltip({
                    html: true
                });
            }
        });
    </script>
@endpush
