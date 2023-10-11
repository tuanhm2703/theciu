@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.create_jd')])
    {!! Form::open([
        'url' => route('admin.recruitment.jd.store')
    ]) !!}
        @include('admin.pages.recruitment.jd.form')
        <div class="text-start my-3 ps-3 mb-5">
            <button type="submit" class="btn btn-primary">{{ trans('labels.create') }}</button>
        </div>
    {!! Form::close() !!}
@endsection
