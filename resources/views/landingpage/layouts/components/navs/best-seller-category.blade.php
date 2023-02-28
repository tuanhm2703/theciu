<li>
    <a href="{{ route('client.product.sale_off') }}">Best Seller</a>

    <div class="megamenu megamenu-sm">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="menu-col">
                    <ul>
                        @foreach ($best_seller_categories as $category)
                            <li>
                                <a href="{{ route('client.product.index', ['category' => $category->slug]) }}">
                                    {{ $category->name }}<span><span class="tip tip-new">Best seller</span></span>
                                </a>
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
                    @foreach ($best_seller_categories as $category)
                        <a href="{{ route('client.product.details', ['category' => $category->slug]) }}">
                            <img src="{{ optional($category->image)->path_with_domain }}" alt="Banner">

                            <div class="banner-content banner-content-bottom">
                                <div class="banner-title text-white">{{ $category->name }}</div>
                                <!-- End .banner-title -->
                            </div><!-- End .banner-content -->
                        </a>
                    @endforeach
                </div><!-- End .banner -->
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->
    </div><!-- End .megamenu megamenu-sm -->
</li>
