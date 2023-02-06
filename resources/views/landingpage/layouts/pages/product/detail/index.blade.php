@extends('landingpage.layouts.app', [
    'metaTags' => $product->getMetaTags()
])
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nouislider/nouislider.css') }}">
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ trans('labels.product') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <div class="col-2">
                                    <div id="product-zoom-gallery" class="product-image-gallery d-block w-100">
                                        @foreach ($product->images as $image)
                                            <a class="product-gallery-item product-image-check active w-100" href="#"
                                                data-image="{{ $image->path_with_domain }}"
                                                data-zoom-image="{{ $image->path_with_domain }}">
                                                <img src="{{ $image->path_with_domain }}" alt="product side">
                                            </a>
                                        @endforeach
                                    </div><!-- End .product-image-gallery -->
                                </div>
                                <div class="col-10">
                                    <figure class="product-main-image">
                                        <img id="product-zoom" src="{{ $product->images->first()->path_with_domain }}"
                                            data-zoom-image="{{ $product->images->first()->path_with_domain }}"
                                            alt="product image">

                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    </figure><!-- End .product-main-image -->
                                </div>
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $product->name }}</h1><!-- End .product-title -->

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                            </div><!-- End .rating-container -->
                            @component('components.product-price-label', compact('product'))
                            @endcomponent

                            <div class="product-content">
                                <p>{{ $product->short_description }}</p>
                            </div><!-- End .product-content -->
                            <livewire:product-pick-item-component :product="$product"></livewire:product-pick-item-component>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Danh mục:</span>
                                    @php
                                        $category = $product->category;
                                        $arr = [];
                                        while ($category) {
                                            $route = route('client.product.index', ['category' => $category->slug]);
                                            $arr[] = "<a href='$route'>$category->name</a>";
                                            $category = $category->category;
                                        }
                                    @endphp
                                    {!! implode(', ', $arr) !!}
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                            class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                            class="icon-pinterest"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="bg-light p-5 mb-3">
                <h6 class="mb-3">CHI TIẾT SẢN PHẨM</h6>
                <div class="product-detail-info-wrapper">
                    @php
                        $category = $product->category;
                        $arr = ['<a href="/">THE CIU</a>'];
                        while ($category) {
                            $route = route('client.product.index', ['category' => $category->slug]);
                            $arr[] = "<a href='$route'>$category->name</a>";
                            $category = $category->category;
                        }
                    @endphp
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0"
                            for="">{{ trans('labels.category') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {!! implode('<span class="px-3"> > </span>', $arr) !!}
                        </div>
                    </div>
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0"
                            for="">{{ trans('labels.material') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {{ $product->material }}
                        </div>
                    </div>
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.style') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {{ $product->style }}
                        </div>
                    </div>
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.model') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {{ $product->model }}
                        </div>
                    </div>
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.type') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {{ $product->type }}
                        </div>
                    </div>
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.ship_from') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {{ App\Models\Config::first()->pickup_address->province->name }}
                        </div>
                    </div>

                </div>
            </div>
            <div class="bg-light p-5 mb-3">
                <h6 class="text-uppercase mb-3">{{ trans('labels.additional_information') }}</h6>
                <div>
                    {!! $product->additional_information !!}
                </div>
            </div>
            <div class="bg-light p-5 mb-3">
                <h6 class="text-uppercase mb-3">{{ trans('labels.shipping_and_return') }}</h6>
                <div>
                    {!! $product->shipping_and_return !!}
                </div>
            </div>

            <h2 class="title text-center mb-4">Sản phẩm tương tự</h2><!-- End .title text-center -->

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                @foreach ($other_products as $o_product)
                    @component('components.client.product-card', ['product' => $o_product])
                    @endcomponent
                @endforeach
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@push('js')
    {{-- <script src="{{asset('assets/landingpage/js/product-detail.js')}}"></script> --}}
@endpush
