@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.create_jd')])
    {!! Form::model($jd, [
        'url' => route('admin.recruitment.jd.update', $jd->id),
        'method' => 'PUT'
    ]) !!}
        @include('admin.pages.recruitment.jd.form')
        <div class="text-start my-3 ps-3 mb-5">
            <button type="submit" class="btn btn-primary">{{ trans('labels.save') }}</button>
        </div>
    {!! Form::close() !!}
@endsection
