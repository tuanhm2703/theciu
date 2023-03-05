<div>
    <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">
                {{ $title ? $title : 'Danh sách sản phẩm' }}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active"><a
                        href="#">{{ isset($title) ? $title : 'Danh sách sản phẩm' }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="products mb-3">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <a href="#" class="sidebar-toggler"><i
                                        class="icon-bars"></i>{{ trans('labels.filters') }}</a>
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-center">
                                <div class="toolbox-info">
                                    <div class="search-wrapper-wide d-flex align-items-center">
                                        <a href="#" wire:click.prevent="searchProduct(1)"><i
                                                class="icon-search"></i></a>
                                        <input wire:model.lazy="keyword" type="search"
                                            wire:keydown.enter="searchProduct(1)" class="form-control" name="q"
                                            id="q" placeholder="Tìm sản phẩm..." required="">
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
                                <div class="col-6 col-md-4">
                                    <livewire:client.product-card-component
                                        wire:key="product-{{ $product->id . time() }}" :product="$product">
                                    </livewire:client.product-card-component>
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                        </div>
                        <div>
                            <div class="toolbox-info text-center">
                                {!! trans('labels.product_paging_description', [
                                    'current' => $products->count(),
                                    'total' => $total
                                ]) !!}
                            </div><!-- End .toolbox-info -->
                        </div>
                    </div><!-- End .products -->

                    <div class="load-more-container text-center">
                        <div class="text-center">
                            @if ($hasNext)
                                <button class="btn" wire:click="nextPage">
                                    <div class="text-center" wire:loading>
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">{{ trans('labels.loading') }}...</span>
                                        </div>
                                    </div>
                                    <span wire:loading.remove>Xem thêm</span>
                                </button>
                            @endif
                        </div>
                    </div><!-- End .load-more-container -->
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
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
                                        @foreach ($product_categories as $category)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="params-categories"
                                                        value="{{ $category->id }}" wire:model="categories"
                                                        wire:change="searchProduct(1)" class="custom-control-input"
                                                        id="cat-{{ $category->id }}">
                                                    <label class="custom-control-label"
                                                        for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                                </div><!-- End .custom-checkbox -->
                                                <span wire:ignore
                                                    class="item-count">{{ $category->products_count }}</span>
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
                                            <input type="number" wire:model.lazy="min_price"
                                                wire:change="searchProduct(1)"
                                                placeholder="{{ trans('placeholder.min_price') }}">
                                            <div class="mx-1"
                                                style="
                                                background-color: #dadada;
                                                width: 10%;
                                                height: 2px;
                                                align-self: center;
                                            ">
                                            </div>
                                            <input type="number" wire:model.lazy="max_price"
                                                wire:change="searchProduct(1)"
                                                placeholder="{{ trans('placeholder.max_price') }}">
                                        </div><!-- End .filter-price-text -->

                                        <div id="price-slider"></div><!-- End #price-slider -->
                                    </div><!-- End .filter-price -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
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
                                    @foreach ($product_categories as $category)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="params-categories"
                                                    value="{{ $category->id }}" wire:model="categories"
                                                    wire:change="searchProduct(1)" class="custom-control-input"
                                                    id="cat-{{ $category->id }}">
                                                <label class="custom-control-label"
                                                    for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span wire:ignore
                                                class="item-count">{{ $category->products_count }}</span>
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
                                        <input type="number" wire:model.lazy="min_price"
                                            wire:change="searchProduct(1)"
                                            placeholder="{{ trans('placeholder.min_price') }}">
                                        <div class="mx-1"
                                            style="
                                            background-color: #dadada;
                                            width: 10%;
                                            height: 2px;
                                            align-self: center;
                                        ">
                                        </div>
                                        <input type="number" wire:model.lazy="max_price"
                                            wire:change="searchProduct(1)"
                                            placeholder="{{ trans('placeholder.max_price') }}">
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
