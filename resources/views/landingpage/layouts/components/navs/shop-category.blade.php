<li>
    <a href="#" class="sf-with-ul">New</a>

    <div class="megamenu megamenu-sm">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="menu-col">
                    <ul>
                        @foreach ($shop_categories as $c)
                            <li>
                                <a href="{{ route('client.product.index', ['category' => $c->slug]) }}">{{ $c->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div><!-- End .menu-col -->
            </div><!-- End .menu-col -->
            <div class="col-md-6">
                <div class="banner banner-overlay owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
                    data-owl-options='{
                        "nav": false,
                        "dots": false,
                        "autoplay": true,
                        "autoplayTimeout": 3000
                    }'>
                    @foreach ($shop_categories as $c)
                        <a href="{{ route('client.product.index', ['category' => $c->slug]) }}">
                            <img src="{{ optional($c->image)->path_with_domain }}" alt="Banner">
                            <div class="banner-content banner-content-bottom">
                                <div class="banner-title text-white">{{ $c->name }}</div>
                                <!-- End .banner-title -->
                            </div><!-- End .banner-content -->
                        </a>
                    @endforeach
                </div><!-- End .banner -->
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->
    </div><!-- End .col-md-6 -->
</li>
