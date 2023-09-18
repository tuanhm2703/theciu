@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <div>
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('client.product.sale_off') }}">Sale Off</a></li>
                        <li class="breadcrumb-item active"><a href="#">Combo khuyến mãi</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
                @if ($banners->count() > 0)
                    <div class="intro-slider-container desktop-banner-slider container" wire:ignore>
                        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
                            data-owl-options='{
                            "dots": false,
                            "nav": false,
                            "autoplay": true,
                            "autoplayTimeout": 3000,
                            "responsive": {
                                "992": {
                                    "nav": true
                                }
                            }
                        }'>
                            @foreach ($banners as $banner)
                                <div class="intro-slide">
                                    <img data-href="{{ $banner->url }}" class="banner-href-img"
                                        alt="THE C.I.U BANNER - {{ $banner->title }}"
                                        src="{{ $banner->desktopImage?->path_with_domain }}">
                                    {{-- <div class="container intro-content text-center">
                                    <h3 class="intro-subtitle text-white">{{ $banner->title }}</h3><!-- End .h3 intro-subtitle -->
                                    <h1 class="intro-title text-white">{{ $banner->title }}</h1><!-- End .intro-title -->

                                    <a href="{{ $banner->url }}" class="btn btn-outline-white-4">
                                        <span>Xem thêm</span>
                                    </a>
                                </div><!-- End .intro-content --> --}}
                                </div><!-- End .intro-slide -->
                            @endforeach
                        </div><!-- End .intro-slider owl-carousel owl-theme -->

                        <span class="slider-loader"></span><!-- End .slider-loader -->
                    </div><!-- End .intro-slider-container -->
                    <div class="intro-slider-container phone-banner-slider" wire:ignore>
                        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
                            data-owl-options='{
                            "dots": true,
                            "nav": false,
                            "autoplay": true,
                            "autoplayTimeout": 3000,
                            "responsive": {
                                "992": {
                                    "nav": true
                                }
                            }
                        }'>
                            @foreach ($banners as $banner)
                                <div class="intro-slide">
                                    <img data-href="{{ $banner->url }}" class="banner-href-img" alt="the ciu banner"
                                        src="{{ $banner->phoneImage->path_with_domain }}">
                                    {{-- <div class="container intro-content text-center">
                                    <h3 class="intro-subtitle text-white">{{ $banner->title }}</h3><!-- End .h3 intro-subtitle -->
                                    <h1 class="intro-title text-white">{{ $banner->title }}</h1><!-- End .intro-title -->

                                    <a href="{{ $banner->url }}" class="btn btn-outline-white-4">
                                        <span>Xem thêm</span>
                                    </a>
                                </div><!-- End .intro-content --> --}}
                                </div><!-- End .intro-slide -->
                            @endforeach
                        </div><!-- End .intro-slider owl-carousel owl-theme -->

                        <span class="slider-loader"></span><!-- End .slider-loader -->
                    </div><!-- End .intro-slider-container -->
                @endif

                <div class="container mt-5">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($combos as $combo)
                                <h5 class="font-weight-bold text-uppercase">
                                    {{ $combo->name }}
                                </h5>
                                <div class="row">
                                    @foreach ($combo->products as $product)
                                        <div class="col-6 col-md-3">
                                            <livewire:client.product-card-component wire:ignore
                                                wire:key="product-{{ $product->id . time() }}" :product="$product">
                                            </livewire:client.product-card-component>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </div>
    </main><!-- End .main -->
@endsection
