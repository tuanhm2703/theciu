@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.order_list') }}</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->
    </main><!-- End .main -->
@endsection
