@extends('admin.layouts.app')
@push('style')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.staff_management')])
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h6>{{ trans('nav.staff_management') }}</h6>
                <a type="button" data-link="{{ route('admin.setting.staff.create') }}" data-modal-size="sm"
                    class="ajax-modal-btn btn btn-primary">{{ trans('labels.add_staff') }}</a>

            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="staff-table table align-items-center">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('labels.name') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ trans('labels.role') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ trans('labels.created_at') }}</th>
                                <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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
        const table = $('.staff-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.setting.staff.paginate') }}",
            "columns": [{
                    data: "name"
                },
                {
                    data: "role"
                },
                {
                    data: "created_at"
                },
                {
                    data: "action",
                    orderable: false,
                    searchable: false
                },
            ],
        })
    </script>
@endpush
