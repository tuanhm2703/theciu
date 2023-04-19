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
            <a href="https://www.instagram.com/theciusaigon/" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="https://www.tiktok.com/@theciusaigon" class="social-icon" target="_blank" title="Tiktok">
                <i style="width: 10px">
                    <svg style="fill: grey;" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512">
                        <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                        <path
                            d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z" />
                    </svg>
                </i>
            </a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
