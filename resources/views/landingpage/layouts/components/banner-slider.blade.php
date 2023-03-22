<div class="intro-slider-container">
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
                <img alt="the ciu banner" src="{{ $banner->image->path_with_domain }}">
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
