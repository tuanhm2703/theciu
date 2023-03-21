<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>
        <livewire:client.mobile-search-component/>

        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="active">
                    <a href="/">{{ trans('labels.dashboard') }}</a>
                </li>
                @include('landingpage.layouts.components.navs.shop-category')
                @include('landingpage.layouts.components.navs.product-category')
                @include('landingpage.layouts.components.navs.best-seller-category');
                @include('landingpage.layouts.components.navs.promotion')
            </ul>
        </nav><!-- End .mobile-nav -->

        <div class="social-icons">
            <a href="https://www.facebook.com/The.C.I.U.2016" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="https://www.instagram.com/theciu2016/" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="https://www.tiktok.com/@theciusaigon" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
