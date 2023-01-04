<div class="pt-2 pb-3">
    <div class="container">
        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
            data-owl-options='{
            "dots": false,
            "nav": false,
            "margin": 30,
            "autoplay": true,
            "autoplayTimeout": 3000,
            "items": 3,
            "responsive": {
                "992": {
                    "nav": true
                }
            }
        }'>
            @foreach ($slide_categories as $c)
                <div class="banner banner-overlay h-100">
                    <a href="{{ route('client.product.index', ['category' => $c->slug]) }}" class="category-card-img"
                        style="background: url({{ $c->image->path_with_domain }})">
                    </a>

                    <div class="banner-content banner-content-center">
                        {{-- <h4 class="banner-subtitle text-white"><a href="#">Danh mục THE CIU</a></h4> --}}
                        <!-- End .banner-subtitle -->
                        <h3 class="banner-title text-white"><a href="#"><strong>{{ $c->name }}</strong></h3>
                        <!-- End .banner-title -->
                        <a href="{{ route('client.product.index', ['category' => $c->slug]) }}" class="btn btn-outline-white banner-link underline">Mua ngay</a>
                    </div><!-- End .banner-content -->
                </div><!-- End .col-sm-6 -->
            @endforeach
        </div><!-- End .bg-gray -->
    </div>
</div>
