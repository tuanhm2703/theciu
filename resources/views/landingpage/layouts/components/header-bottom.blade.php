<div class="header-bottom sticky-header">
    <div class="container">
        <div class="header-left">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="megamenu-container active">
                        <a href="/">Trang chủ</a>
                    </li>
                    @include('landingpage.layouts.components.navs.shop-category')
                    @include('landingpage.layouts.components.navs.product-category')
                    @include('landingpage.layouts.components.navs.promotion')
                    @include('landingpage.layouts.components.navs.blog')
                </ul><!-- End .menu -->
            </nav><!-- End .main-nav -->

            <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
            </button>
        </div><!-- End .header-left -->

        <div class="header-right">
            <i class="la la-lightbulb-o"></i>
            <p>Clearance Up to 30% Off</span></p>
        </div>
    </div><!-- End .container -->
</div><!-- End .header-bottom -->
<div class="mobile-menu-overlay">
    @include('landingpage.layouts.components.header-bottom-phone')
</div><!-- End .mobil-menu-overlay -->
