@extends('landingpage.layouts.app')
@push('css')
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="container">
        <div id="wpm-app">

        </div>
    </div>
    </div><!-- End .page-content -->
@endsection
