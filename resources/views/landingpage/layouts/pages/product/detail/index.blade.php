@extends('landingpage.layouts.app', [
    'metaTags' => $product->getMetaTags(),
])
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        .swiper-slide {
            height: fit-content !important;
        }
    </style>
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.product.index') }}">{{ trans('labels.product') }}</a>
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('client.product.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical h-100">
                            <div class="row h-100">
                                <div class="col-2 p-0"
                                    style="max-height: 630px;
                                overflow: hidden;">
                                    <div id="product-zoom-gallery" class="product-image-gallery d-block w-100">
                                        @if ($product->video)
                                            <video class="product-video-item"
                                                data-video="{{ $product->video->path_with_domain }}" width="100%"
                                                src="{{ $product->video->path_with_domain }}"></video>
                                        @endif
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                @foreach ($product->images as $image)
                                                    <div class="swiper-slide">
                                                        <a class="product-gallery-item product-image-check active w-100 p-0"
                                                            href="#" data-image="{{ $image->path_with_domain }}"
                                                            data-zoom-image="{{ $image->path_with_domain }}">
                                                            <img src="{{ $image->path_with_domain }}" alt="product side">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div><!-- End .product-image-gallery -->
                                </div>
                                <div class="col-10 h-100 d-flex align-items-center bg-light"
                                    style="height: fit-content !important;">
                                    <figure class="product-main-image">
                                        @if ($product->video)
                                            <video id="video-previewer" width="100%" controls autoplay muted>
                                                <source src="{{ $product->video->path_with_domain }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="d-none">
                                                <img id="product-zoom"
                                                    src="{{ $product->images->first()->path_with_domain }}"
                                                    data-zoom-image="{{ $product->images->first()->path_with_domain }}"
                                                    alt="product image">

                                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                                    <i class="icon-arrows"></i>
                                                </a>
                                            </div>
                                        @else
                                            <img id="product-zoom" src="{{ $product->images->first()->path_with_domain }}"
                                                data-zoom-image="{{ $product->images->first()->path_with_domain }}"
                                                alt="product image">

                                            <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                                <i class="icon-arrows"></i>
                                            </a>
                                        @endif
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
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.category') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {!! implode('<span class="px-3"> > </span>', $arr) !!}
                        </div>
                    </div>
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.material') }}</label>
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
                        <label class="product-detail-label w-20 m-0"
                            for="">{{ trans('labels.ship_from') }}</label>
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

            <livewire:client.other-product-component :product="$product"></livewire:client.other-product-component>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@push('js')
    <script>
        var swiper = new Swiper('.swiper-container', {
            direction: 'vertical',
            slidesPerView: 5
        });
    </script>
@endpush
