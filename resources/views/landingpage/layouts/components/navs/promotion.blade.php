<li>
    <a href="#" class="sf-with-ul">Sale off</a>

    <div class="megamenu megamenu-sm">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="menu-col">
                    <ul>
                        @foreach ($promotions as $p)
                            <li><a
                                    href="{{ route('client.product.index', ['promotion' => $p->slug]) }}">{{ $p->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div><!-- End .menu-col -->
            </div><!-- End .col-md-6 -->

            <div class="col-md-6">
                <div class="banner banner-overlay owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
                    data-owl-options='{
                    "nav": false,
                    "dots": false,
                    "autoplay": true,
                    "autoplayTimeout": 3000
                }'>
                    @foreach ($promotions as $promotion)
                        @foreach ($promotion->products as $p)
                            <a href="{{ route('client.product.details', $p->slug) }}">
                                <img src="{{ $p->image->path_with_domain }}" alt="Banner">

                                <div class="banner-content banner-content-bottom">
                                    <div class="banner-title text-white">{{ $p->name }}</div>
                                    <!-- End .banner-title -->
                                </div><!-- End .banner-content -->
                            </a>
                        @endforeach
                    @endforeach
                </div><!-- End .banner -->
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->
    </div><!-- End .megamenu megamenu-sm -->
</li>
