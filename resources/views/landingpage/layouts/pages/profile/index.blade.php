@extends('landingpage.layouts.app')
@section('content')
    <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{ trans('labels.my_account') }}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.my_account') }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <livewire:profile-content-component :content="isset(Request::query()['tab']) ? Request::query()['tab'] : 'profile'"></livewire:profile-content-component>
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
@endsection
