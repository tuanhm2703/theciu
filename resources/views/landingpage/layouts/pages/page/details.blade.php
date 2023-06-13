@extends('landingpage.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        .page-content .footer {
            background: white;
        }
        .page-content * {
            max-width: 100% !important;
            font-family: 'Mulish', sans-serif !important;
        }
        .page-content span {
            font-size: 1.4rem !important;
        }
    </style>
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <h6>{{ $page->titke }}</h6>
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
