@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.branch_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.category')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.category_list') }}</h6>
                    <a class="btn btn-primary btn-sm ms-auto" href="{{ route('admin.branch.create') }}">
                        <i class="fas fa-plus"></i>{{ trans('labels.create_branch') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-3">
                    <table class="branch-table table align-items-center mb-0">
                        <thead>
                            <tr>
                                <td>
                                    <div class="form-check text-center form-check-info">
                                        <input type="checkbox" class="editor-active form-check-input mass-checkbox-btn">
                                    </div>
                                </td>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.name') }}</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.address') }}</th>
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
        const table = $('.branch-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.branch.paginate') }}",
            "columns": [{
                    data: "id",
                },
                {
                    data: "name"
                },
                {
                    data: "address.full_address"
                },
                {
                    data: "action"
                },
            ],
            order: [
                [1, 'desc']
            ],
        });
    </script>
@endpush
