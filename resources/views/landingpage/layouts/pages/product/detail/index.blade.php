@extends('landingpage.layouts.app', [
    'headTitle' => $product->page_title,
    'shemaMarkup' => view('components.client.schema-markup', compact('product')),
])
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        .swiper-slide {
            height: fit-content !important;
        }

        .popup-media {
            position: relative;
            display: block;
            height: 100px;
            width: 100px;
            background: #fff;
            max-width: 100px;
            background-size: cover !important;
            background-position: center !important;
        }

        .popup-media img,
        .popup-media video {
            max-width: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .popup-media .video-icon-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2rem;
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
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <livewire:client.product-detail-info-component :product="$product" />

            <div class="bg-light p-5 mb-3">
                <h6 class="mb-3">CHI TIẾT SẢN PHẨM</h6>
                <div class="product-detail-info-wrapper">
                    @php
                        $category = $product->category;
                        $arr = [];
                        while ($category) {
                            $route = route('client.product.index', ['category' => $category->slug]);
                            $arr[] = "<a href='$route'>$category->name</a>";
                            $category = $category->category;
                        }
                        $arr[] = '<a href="/">THE CIU</a>';
                    @endphp
                    <div class="d-flex">
                        <label class="product-detail-label w-20 m-0" for="">{{ trans('labels.category') }}</label>
                        <div class="d-flex align-items-center product-detail-content">
                            {!! implode('<span class="px-3"> > </span>', array_reverse($arr)) !!}
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
            <div class="bg-light p-5 mb-3">
                <h6 class="text-uppercase mb-3">{{ trans('labels.product_review') }}</h6>
                <div class="reviews">
                    @foreach ($reviews as $review)
                        <div class="review">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <div class="text-center">
                                        <a class="social-icon" target="_blank" style="overflow: hidden"><img
                                                src="{{ $review->customer->avatar_path }}" alt=""></a>
                                    </div>
                                    <h4 class="mb-0"><a href="#">{{ $review->customer->full_name }}</a></h4>
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: {{ $review->product_score * 20 }}%;">
                                            </div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                    </div><!-- End .rating-container -->
                                </div><!-- End .col -->
                                <div class="col">
                                    <span class="review-date">{{ carbon($review->created_at)->format('d-m-y H:i:s') }} |
                                        Phân loại hàng: {{ $review->order->inventories[0]->title }}</span>
                                    <p>Đánh giá: <span class="font-weight-bold">{{ $review->details }}</span>
                                    </p>
                                    <div class="d-flex flex-nowrap">
                                        @if ($review->video)
                                            <div class="p-1">
                                                <a class="popup-vimeo popup-media"
                                                    style="background: url({{ $review->video->thumbnail_url }})"
                                                    href="{{ $review->video->path_with_domain }}">
                                                    <div class="video-icon-label">
                                                        <i class="far fa-play-circle"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        @foreach ($review->images as $image)
                                            <div class="p-1">
                                                <a href="{{ $image->path_with_domain }}" class="img-popup popup-media"
                                                    style="background: url({{ $image->path_with_domain }})">
                                                    {{-- <img src="{{ $image->path_with_domain }}" alt=""> --}}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="review-action">
                                        <a href="#">
                                            {!! Form::open([
                                                'url' => route('client.auth.review.like', $review->id),
                                                'method' => 'PUT',
                                                'class' => 'review-react-form'
                                            ]) !!}
                                                <button type="submit" class="icon-thumbs-up btn btn-link border-0 px-0 text-dark"></button>
                                            {{ $review->likes ? $review->likes : '' }}
                                            {!! Form::close() !!}
                                        </a>
                                    </div><!-- End .review-action -->
                                </div><!-- End .col-auto -->
                            </div><!-- End .row -->
                        </div><!-- End .review -->
                    @endforeach
                </div><!-- End .reviews -->
            </div>

            <h2 class="title text-center mb-4">Sản phẩm tương tự</h2><!-- End .title text-center -->

            <livewire:client.other-product-component :product="$product"></livewire:client.other-product-component>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
@push('js')
    <script>
        var swiper = new Swiper(".mySwiper", {
            direction: "vertical",
            slidesPerView: 'auto',
            spaceBetween: 5,
            loop: true,
            mousewheel: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            }
        });
        $('.review-react-form').ajaxForm({
            beforeSend: function(xhr, options, $i) {
                console.log(xhr, options, $i);
                console.log(this);
            },
            success: function(response, statusText, xhr, $form) {
                console.log($form);
            },
            error: (err) => {
                if(err.status === 401) {
                    openLoginModal()
                }
            }
        })
    </script>
@endpush
