@extends('landingpage.layouts.app', ['showFooterComponent' => false])
@section('content')
<div>
    {{-- <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">
                {{ $title ? $title : 'Danh sách sản phẩm' }}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header --> --}}
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">404</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="error-content text-center" style="background-image: url(assets/images/backgrounds/error-bg.jpg)">
        <div class="container">
            <h1 class="error-title">{{ trans('labels.error_404') }}</h1><!-- End .error-title -->
            <p>{{ trans('labels.404_error_message') }}</p>
            <a href="/" class="btn btn-outline-primary-2 btn-minwidth-lg">
                <span>{{ trans('labels.back_to_homepage') }}</span>
                <i class="icon-long-arrow-right"></i>
            </a>
        </div><!-- End .container -->
    </div><!-- End .error-content text-center -->
</div>
@endsection
