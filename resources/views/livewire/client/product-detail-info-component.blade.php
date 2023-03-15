<div class="product-details-top">
    <div wire:loading wire:ignore wire:target="changeProduct">
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="quickView-content" wire:loading.remove wire:target="changeProduct">
        @if ($product)
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <div class="row">
                        <div class="product-left">
                            @if ($product->video)
                                <a href="#{{ $product->video->name }}" class="carousel-dot d-block">
                                    <video controls autoplay width="100%">
                                        <source src="{{ $product->video->path_with_domain }}" type="video/mp4">
                                    </video>
                                </a>
                            @endif
                            @foreach ($product->images as $index => $image)
                                <a href="#{{ $image->name }}" class="carousel-dot {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $image->path_with_domain }}">
                                </a>
                            @endforeach
                            @foreach ($inventory_images as $index => $image)
                                <a href="#{{ $image->name }}" class="carousel-dot">
                                    <img src="{{ $image->path_with_domain }}">
                                </a>
                            @endforeach
                        </div>
                        <div class="product-right">
                            <div class="owl-carousel owl-theme owl-nav-inside owl-light mb-0" data-toggle="owl"
                                data-owl-options='{
                                    "dots": false,
                                    "nav": false,
                                    "URLhashListener": true,
                                    "lazyLoad": true,
                                    "responsive": {
                                        "900": {
                                            "nav": true,
                                            "dots": true
                                        }
                                    }
                                }'>
                                @if ($product->video)
                                    <div class="intro-slide" data-hash="{{ $product->video->name }}">
                                        <video controls autoplay width="100%" style="max-height: 600px">
                                            <source src="{{ $product->video->path_with_domain }}" type="video/mp4">
                                        </video>
                                    </div><!-- End .intro-slide -->
                                @endif
                                @foreach ($product->images as $image)
                                    <div class="intro-slide" data-hash="{{ $image->name }}">
                                        <img src="{{ $image->path_with_domain }}" alt="Image Desc"
                                            style="max-height: 600px">
                                        {{-- <a href="{{ $image->path_with_domain }}" class="btn-fullscreen">
                                            <i class="icon-arrows"></i>
                                        </a> --}}
                                    </div><!-- End .intro-slide -->
                                @endforeach
                                @foreach ($inventory_images as $image)
                                    <div class="intro-slide" data-hash="{{ $image->name }}">
                                        <img src="{{ $image->path_with_domain }}" alt="Image Desc"
                                            style="max-height: 600px">
                                        {{-- <a href="{{ $image->path_with_domain }}" class="btn-fullscreen">
                                            <i class="icon-arrows"></i>
                                        </a> --}}
                                    </div><!-- End .intro-slide -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
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
                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                    class="icon-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div><!-- End .product-details-top -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (el, component) => {
            try {
                $('.quickView-content .owl-carousel').owlCarousel('destroy')
            } catch (error) {}
            owlCarousels($('.quickView-content'), {
                onTranslate: function(e) {
                    var $this = $(e.target),
                        currentIndex = ($this.data('owl.carousel').current() + e.item.count - Math.ceil(e.item.count / 2)) % e.item.count;
                    $('.quickView-content .carousel-dot').eq(currentIndex).addClass(
                        'active').siblings().removeClass('active');
                }
            });
        })
    });
</script>
