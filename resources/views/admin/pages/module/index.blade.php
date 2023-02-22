@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.product_list')])
@push('style')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.module')])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h6>Danh sách chức năng</h6>
                <button class="btn btn-primary ajax-modal-btn" data-link="{{ route('admin.role.create') }}">
                    {{ trans('labels.create_role') }}
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 role-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ trans('labels.name') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Slug</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ trans('labels.created_at') }}</th>
                                    <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const table = $('.role-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": `{{ route('admin.role.paginate') }}`,
            "columns": [{
                    data: "name"
                },
                {
                    data: "guard_name"
                },
                {
                    data: 'created_at',
                },
                {
                    data: 'action',
                    sortable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
