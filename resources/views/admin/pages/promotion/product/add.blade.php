@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('nav.create_promotion')])
@push('style')
    @include('admin.pages.promotion.product.assets._style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.create_promotion')])
    <div class="container-fluid">
        @include('admin.pages.promotion.product.components.edit-table')
        {{-- <livewire:admin.promotion-detail-component></livewire:admin.promotion-detail-component> --}}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    @include('admin.pages.promotion.product.assets._script')
@endpush
