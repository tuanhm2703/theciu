@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.banner')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('navs.combo_list') }}</h6>
                    <a class="btn btn-primary" href="{{ route('admin.combo.create') }}">
                        {{ trans('labels.create_combo') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="table-responsive p-3">
                    <table class="combo-table table align-items-center mb-0">
                        <thead>
                            <th style="padding-left: 0.5rem">
                                No.
                            </th>
                            <th>{{ trans('labels.combo_name') }}</th>
                            <th class="text-center">{{ trans('labels.product') }}</th>
                            <th>Trạng thái</th>
                            <th>{{ trans('labels.time') }}</th>
                            <th>{{ trans('labels.action') }}</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
    </script>
@endpush
