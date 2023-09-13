@extends('landingpage.layouts.app', [
    'headTitle' => $product->page_title,
    'shemaMarkup' => view('components.client.schema-markup', compact('product')),
])
@section('schema')
    @foreach ($product->getSchemaOrg() as $schema)
        {!! $schema !!}
    @endforeach
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        #combo-sale-wrapper .product-media a.product-image {
            height: 200px !important;
        }

        #combo-sale-wrapper .product-media a.product-image img {
            width: 100% !important;
            height: auto !important;
        }

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

        .reviews li {
            list-style: none;
        }

        .intro-slide {
            height: 100% !important;
        }

        .owl-carousel .owl-item {
            height: 100%;
        }

        .owl-carousel .owl-stage {
            height: 100%;
        }

        .owl-carousel .owl-stage-outer {
            height: 100%;
        }

        .owl-carousel {
            height: 100%;
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

            @if ($product->available_combo)
                <div class="bg-light p-5 mb-3" id="combo-sale-wrapper">
                    <h6 class="mb-3">{{ $product->available_combo?->getComboDiscriptionLabelInProductDetails($product->id) }}</h6>
                    <div class="product-detail-info-wrapper">
                        <div class="row">
                            @foreach ($combo_products as $product)
                                <div class="col-12 col-md-3">
                                    <livewire:client.product-card-component wire:ignore
                                        wire:key="product-{{ $product->id . time() }}" :product="$product">
                                    </livewire:client.product-card-component>
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
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
            @if ($has_review)
                <div class="bg-light p-5 mb-3" id="review-wrapper">
                    <h6 class="text-uppercase mb-3">{{ trans('labels.product_review') }}</h6>
                    <div class="reviews">
                    </div><!-- End .reviews -->
                    <div class="text-center">
                        <a href="javascript::void()" class="read-more loadmore-review">Xem thêm</a>
                    </div>
                </div>
            @endif

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
    </script>
    @if ($has_review)
        <script>
            $('.reviews').scrollPagination({
                url: `{{ route('client.product.review.paginate', $product->slug) }}`,
                data: {
                    page: 1, // which entry to load on init,
                    size: 5,
                },
                autoload: false,
                loading: '.loadmore-review',
                loadingNomoreText: '',
                manuallyText: 'Xem thêm',
                'after': function(elementsLoaded) {
                    $(".img-popup").magnificPopup({
                        type: "image",
                    });
                    $('.popup-vimeo').magnificPopup({
                        disableOn: 700,
                        type: 'iframe',
                        mainClass: 'mfp-fade',
                        removalDelay: 160,
                        preloader: false,

                        fixedContentPos: false
                    });
                    $(elementsLoaded).fadeInWithDelay();
                    $('.review-react-form').ajaxForm({
                        success: function(response, statusText, xhr, $form) {
                            $($form).find('[type=submit] span').text(`${response.data.likes} Hữu ích`)
                            $($form).find('[type=submit]').removeClass('text-dark')
                        },
                        error: (err) => {
                            if (err.status === 401) {
                                openLoginModal()
                            }
                        }
                    })
                }

            });
        </script>
    @endif
@endpush
