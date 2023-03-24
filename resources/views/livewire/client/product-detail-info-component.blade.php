<div class="product-details-top">
    <div class="d-flex justify-content-center h-100">
        <div wire:loading>
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
    </div>
    <div class="quickView-content px-0 pt-0" wire:loading.remove>
        @if ($product)
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <div class="row">
                        <div class="product-left">
                            <div class="swiper mySwiper h-100">
                                <div class="swiper-wrapper px-0">
                                    @if ($product->video)
                                        <a href="#{{ $product->video->name }}"
                                            class="carousel-dot d-block swiper-slide">
                                            <video controls autoplay width="100%" height="100%">
                                                <source src="{{ $product->video->path_with_domain }}" type="video/mp4">
                                            </video>
                                        </a>
                                    @endif
                                    @foreach ($product->images->unique('name') as $index => $image)
                                        <a href="#{{ $image->name }}"
                                            class="carousel-dot swiper-slide {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ $image->path_with_domain }}">
                                        </a>
                                    @endforeach
                                    @foreach ($inventory_images->unique('name') as $index => $image)
                                        @php
                                            $image = (object) $image;
                                        @endphp
                                        <a href="#{{ $image->name }}" class="carousel-dot swiper-slide">
                                            <img src="{{ $image->path_with_domain }}">
                                        </a>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="product-right" id="product-zoom-gallery">
                            <div class="owl-carousel owl-theme owl-nav-inside owl-light mb-0" data-toggle="owl"
                                data-owl-options='{
                                    "dots": false,
                                    "nav": false,
                                    "lazyLoad": true,
                                    "URLhashListener": true,
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
                                @foreach ($product->images->unique('name') as $image)
                                    <div class="intro-slide" data-hash="{{ $image->name }}" wire:ignore>
                                        <img src="{{ $image->path_with_domain }}" alt="Image Desc"
                                            style="max-height: 600px">
                                        {{-- <a href="{{ $image->path_with_domain }}" class="btn-fullscreen">
                                            <i class="icon-arrows"></i>
                                        </a> --}}
                                    </div><!-- End .intro-slide -->
                                @endforeach
                                @foreach ($inventory_images->unique('name') as $image)
                                    @php
                                        $image = (object) $image;
                                    @endphp
                                    <div class="intro-slide" data-hash="{{ $image->name }}" wire:ignore>
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
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (el, component) => {
            if (component.fingerprint.name == 'product-pick-item-component') {
                // quantityInputs()
            }
        });
        $("[data-bs-toggle=tooltip]").tooltip({
                    html: true
                });
        $('body').on('click', '.check-product-thumb-image a', (e) => {
            $(e.currentTarget).parent().click()
        })
    })
</script>
