<div class="header-bottom sticky-header">
    <div class="container">
        <div class="header-left">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="megamenu-container {{ isNavActive('client.home') ? 'active' : '' }}">
                        <a href="/">Trang chủ</a>
                    </li>
                    @include('landingpage.layouts.components.navs.shop-category')
                    @include('landingpage.layouts.components.navs.product-category')
                    @include('landingpage.layouts.components.navs.best-seller-category');
                    @include('landingpage.layouts.components.navs.promotion')
                </ul><!-- End .menu -->
            </nav><!-- End .main-nav -->

            <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
            </button>
        </div><!-- End .header-left -->

        <div class="header-right">
            <livewire:client.header-wishlist-component></livewire:client.header-wishlist-component>
            <livewire:header-cart-component></livewire:header-cart-component>
            @include('landingpage.layouts.components.navs.auth')
        </div>
    </div><!-- End .container -->
</div><!-- End .header-bottom -->
