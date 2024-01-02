@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.create_combo')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.create_combo')])
    <div class="container-fluid">
        {!! Form::open([
            'url' => route('admin.promotion.store'),
            'method' => 'POST',
            'class' => 'promotion-form'
        ]) !!}
                @include('admin.pages.accom-gift.form')
                {!! Form::close() !!}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@include('admin.pages.accom-gift.assets._script')
@endpush
