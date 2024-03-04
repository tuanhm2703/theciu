<div>
    <nav aria-label="breadcrumb" class="breadcrumb-nav {{ isset($banners) && count($banners) > 0 ? 'mb-0' : 'mb-2' }}">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="#">{{ isset($title) ? $title : 'Danh sách sản phẩm' }}</a></li>
                @if ($category_name)
                    <li class="breadcrumb-item active"><a href="#">{{ $category_name }}</a></li>
                @endif
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        @if (isset($banners) && count($banners) > 0)
            <div class="intro-slider-container desktop-banner-slider container p-0" wire:ignore>
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
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="products mb-3">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <a href="#" class="sidebar-toggler d-block"><i
                                        class="icon-bars"></i>{{ trans('labels.filters') }}</a>
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-center">
                                <div class="toolbox-info">
                                    <div class="search-wrapper-wide d-flex align-items-center">
                                        <a href="#" wire:click.prevent="searchProduct(1)"><i
                                                class="icon-search"></i></a>
                                        <input wire:model="keyword" type="search" wire:keydown.enter="searchProduct(1)"
                                            class="form-control" name="q" id="q"
                                            placeholder="Tìm sản phẩm..." required="">
                                        <div class="spinner-border spinner-border-sm" role="status" wire:loading
                                            wire:target="keyword">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        @if (count($search_products) != 0)
                                            <div class="autocomplete-items py-0" wire:ignore.self>
                                                @foreach ($search_products as $product)
                                                    <div class="border-bottom">
                                                        <a href="{{ route('client.product.details', $product->slug) }}"
                                                            class="keyword-picker row">
                                                            <div class="col-2 col-md-3">
                                                                <img src="{{ $product->image->path_with_domain }}"
                                                                    alt="" width="100">
                                                            </div>
                                                            <div class="col-10 col-md-9 pl-0 product-search-info">
                                                                {{ $product->name }} <br>
                                                                @component('components.product-price-label', compact('product'))
                                                                @endcomponent
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <a href="#"
                                                    class="text-center header-keyword-picker d-block p-3 autocomplete-view-more">
                                                    {{ trans('labels.view_more') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div><!-- End .header-search-wrapper -->
                                </div><!-- End .toolbox-info -->
                            </div><!-- End .toolbox-center -->
                        </div><!-- End .toolbox -->
                        <div class="text-center">
                            <div wire:loading wire:target="searchProduct"
                                class="spinner-grow spinner-grow-sm text-center" role="status">
                                <span class="sr-only">{{ trans('labels.loading') }}...</span>
                            </div>
                            <div wire:loading wire:target="searchProduct"
                                class="spinner-grow spinner-grow-sm text-center" role="status">
                                <span class="sr-only">{{ trans('labels.loading') }}...</span>
                            </div>
                            <div wire:loading wire:target="searchProduct"
                                class="spinner-grow spinner-grow-sm text-center" role="status">
                                <span class="sr-only">{{ trans('labels.loading') }}...</span>
                            </div>
                        </div>
                        <div class="row" wire:loading.remove wire:target="searchProduct">
                            @foreach ($products as $product)
                                <div class="col-6 col-md-3">
                                    <livewire:client.product-card-component wire:ignore
                                        wire:key="product-{{ $product->id . time() }}" :product="$product">
                                    </livewire:client.product-card-component>
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                        </div>
                    </div><!-- End .products -->

                    <div class="load-more-container text-center">
                        <div class="text-center">
                            @if ($products->count() > 0)
                                {!! $products->onEachSide(0)->links('components.pagination') !!}
                            @endif
                        </div>
                    </div><!-- End .load-more-container -->
                    @if ($content = \App\Models\Category::whereSlug($category)->first()?->content)
                        <p class="text-center page-content">
                            {!! $content !!}
                        </p>
                    @endif
                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
    <div class="page-content">
        <div class="container">
            <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
            <aside class="sidebar-shop sidebar-filter">
                <div class="sidebar-filter-wrapper">
                    <div class="widget widget-clean">
                        <label><i class="icon-close"></i>{{ trans('labels.filters') }}</label>
                        <a href="#" wire:click="clearAllFilter"
                            class="sidebar-filter-clear">{{ trans('labels.clear_filter') }}</a>
                    </div><!-- End .widget -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                aria-controls="widget-1">
                                {{ trans('labels.category') }}
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-1">
                            <div class="widget-body">
                                <div class="filter-items filter-items-count">
                                    @foreach ($product_categories as $product_cate)
                                        <div class="filter-item">
                                            @if ($promotion || $haspromotion)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="params-categories"
                                                        value="{{ $product_cate->slug }}" wire:model="category"
                                                        wire:change="searchProduct(1)" class="custom-control-input"
                                                        id="cat-{{ $product_cate->slug }}">
                                                    <label class="custom-control-label"
                                                        for="cat-{{ $product_cate->slug }}">{{ $product_cate->name }}</label>
                                                </div>
                                                {{-- <span wire:ignore
                                                class="item-count">{{ $category->products_count }}</span> --}}
                                            @else
                                                <a class="{{ $product_cate->slug == $category ? 'active' : '' }}"
                                                    href="{{ route('client.product_category.index', ['category' => $product_cate->slug, 'keyword' => $keyword]) }}">
                                                    {{ $product_cate->name }}
                                                </a>
                                            @endif
                                        </div><!-- End .filter-item -->
                                    @endforeach
                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true"
                                aria-controls="widget-5">
                                {{ trans('labels.price_range') }}
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-5">
                            <div class="widget-body">
                                <div class="filter-price">
                                    <div class="filter-price-text d-flex align-items-center" wire:ignore>
                                        <div>
                                            <input type="number" wire:model.lazy="min_price" step="50000"
                                                wire:change="searchProduct(1)"
                                                placeholder="{{ trans('placeholder.min_price') }}">
                                        </div>
                                        <div class="mx-1"
                                            style="
                                            background-color: #dadada;
                                            width: 10%;
                                            height: 2px;
                                            align-self: center;
                                        ">
                                        </div>
                                        <div>
                                            <input type="number" wire:model.lazy="max_price" step="50000"
                                                wire:change="searchProduct(1)"
                                                placeholder="{{ trans('placeholder.max_price') }}">
                                        </div>
                                    </div><!-- End .filter-price-text -->

                                    <div id="price-slider"></div><!-- End #price-slider -->
                                </div><!-- End .filter-price -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->
                </div><!-- End .sidebar-filter-wrapper -->
            </aside><!-- End .sidebar-filter -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (el, component) => {
            // $(".add-to-cart-btn").on("click", function(e) {
            //     if ($(e.currentTarget).attr('data-product-id')) {
            //         Livewire.emit('changeProduct', $(e.currentTarget).attr('data-product-id'))
            //         $.magnificPopup.open({
            //             items: {
            //                 src: $("#test-popup"),
            //                 type: "inline",
            //             },
            //         });
            //     }
            // });
        })
        $('input[name=q]').focusout(e => {
            const relatedElement = $($(e.relatedTarget)[0])
            const classes = relatedElement.attr('class')?.split(' ')
            if (classes) {
                if (classes.includes('autocomplete-view-more')) {
                    @this.searchProduct(1)
                }
                if (classes.includes('keyword-picker')) {
                    window.location.replace(relatedElement.attr('href'));
                }
            }
            setTimeout(() => {
                $('.toolbox .autocomplete-items').addClass('d-none');
            }, 50);
        })
        $('input[name=q]').focus(e => {
            $('.toolbox .autocomplete-items').removeClass('d-none');
        })
    })
    $('.toolbox .autocomplete-items').addClass('d-none');
</script>
