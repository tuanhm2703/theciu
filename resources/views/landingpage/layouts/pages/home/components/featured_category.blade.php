<div class="pt-2 pb-3 mt-3">
    <div class="heading heading-center mb-3">
        <h2 class="title">Danh mục nổi bật</h2><!-- End .title -->
    </div>
    <div class="container">
        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
            data-owl-options='{
            "dots": false,
            "nav": false,
            "margin": 30,
            "autoplay": true,
            "autoplayTimeout": 3000,
            "items": 1,
            "loop": true,
            "center": true,
            "responsive": {
                "992": {
                    "nav": true,
                    "items": 3
                },
                "576": {
                    "items": 2
                }
            }
        }'>
            @foreach ($featured_categories as $c)
                <div class="banner banner-overlay h-100">
                    <a href="{{ route('client.product.index', ['category' => $c->slug]) }}" class="category-card-img"
                        style="background: url({{ optional($c->image)->path_with_domain }})">
                    </a>
                    <div class="banner-content banner-content-center">
                        {{-- <h4 class="banner-subtitle text-white"><a href="#">Danh mục THE CIU</a></h4> --}}
                        <!-- End .banner-subtitle -->
                        <!-- End .banner-title -->
                    </div><!-- End .banner-content -->
                    <h3 class="banner-title text-white text-center my-3">
                        <a href="#" ><strong style="color: black">{{ $c->name }}</strong></a>
                        </h3>
                    <a href="{{ route('client.product.index', ['category' => $c->slug]) }}" style="color: black" class="btn btn-outline-white banner-link underline">Mua ngay</a>
                </div><!-- End .col-sm-6 -->
            @endforeach
        </div><!-- End .bg-gray -->
    </div>
</div>
