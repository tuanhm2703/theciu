@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.update_product')])
@push('style')
    @include('admin.pages.product.form.assets._style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.update_product')])
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 col-lg-10">
                @include('admin.pages.product.form.edit')
            </div>
            <div class="col-md-3 col-lg-2">
                @include('admin.pages.product.components.product-step-sidebar')
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@endpush
