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
                <div class="row">
                    <aside class="col-md-3 col-lg-2">
                        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'client.auth.profile.order.index' ? 'active' : '' }}"
                                    id="content-tab" href="{{ route('client.auth.profile.order.index') }}" role="tab"
                                    aria-controls="tab-orders" aria-selected="false"><i
                                        class="fas fa-shopping-cart text-light"></i>
                                    {{ trans('labels.order_list') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'client.auth.profile.address.index' ? 'active' : '' }}"
                                    id="content-tab" href="{{ route('client.auth.profile.address.index') }}" role="tab"
                                    role="tab" aria-controls="tab-address" aria-selected="false"><i
                                        class="fa fa-location-arrow text-light" aria-hidden="true"></i>
                                    {{ trans('labels.address') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'client.auth.profile.index' ? 'active' : '' }}"
                                    id="content-tab" href="{{ route('client.auth.profile.index') }}" role="tab"
                                    role="tab" aria-controls="tab-account" aria-selected="false"><i
                                        class="fa fa-user text-light" aria-hidden="true"></i>
                                    {{ trans('labels.account_info') }}</a>
                            </li>
                        </ul>
                    </aside><!-- End .col-lg-3 -->
                    <div class="col-md-9 col-lg-10">
                        <div class="tab-content">
                            <div class="tab-pane active pr-3" id="tab-content" role="tabpanel"
                                aria-labelledby="tab-orders-link" style="min-height: 50vh">
                                <div class="text-center" wire:loading>Loading...</div>
                                <div class="page-content container w-100" wire:loading.remove>
                                    @yield('profile-content')
                                </div><!-- End .page-content -->
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div>
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
@endsection
@push('js')
    <script></script>
@endpush
