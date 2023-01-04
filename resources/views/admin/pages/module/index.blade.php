@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.module')])
    <div class="container-fluid">
        <x-admin.card header="Danh sách chức năng">
            <div class="row">
                <div class="col-md-2">
                    <label for="" class="custom-control-label">Chọn chức năng: </label>
                </div>
                <div class="col-md-3">
                    <select name="module" id="" class="form-control" placeholder="Chọn chức năng">
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 permission-table">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Slug</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Created at</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-admin.card>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const initPermissionTable = (moduleId = null) => {
            if (moduleId == null) return null
            return $('.permission-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": `/admin/ajax/module/${moduleId}/permissions`,
                "columns": [{
                        data: "name"
                    },
                    {
                        data: "slug"
                    },
                    {
                        data: 'created_at',
                    }
                ],
                // "initComplete": function(settings, json) {
                //     // showConfirm(content = 'Demo')
                //     $('.ajax-form-confirm').ajaxForm({
                //         success: (res) => {
                //             table.ajax.reload()
                //         }
                //     })
                // }
            });
        }
        initPermissionTable($('select[name="module"]').val())
    </script>
@endpush
