<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 text-center" href="{{ route('admin.home') }}">
            <img src="{{ asset('img/logo-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @include('admin.layouts.navbars.auth.nav-group.product')
            @include('admin.layouts.navbars.auth.nav-group.category')
            @include('admin.layouts.navbars.auth.nav-group.policy')
            @include('admin.layouts.navbars.auth.nav-group.module')
            @include('admin.layouts.navbars.auth.nav-group.promotion')
            @include('admin.layouts.navbars.auth.nav-group.rank')
            @include('admin.layouts.navbars.auth.nav-group.appearance')
            @include('admin.layouts.navbars.auth.nav-group.setting')
            @include('admin.layouts.navbars.auth.nav-group.review')
            @include('admin.layouts.navbars.auth.nav-group.order')
            @include('admin.layouts.navbars.auth.nav-group.customer')
            @include('admin.layouts.navbars.auth.nav-group.page')
            @include('admin.layouts.navbars.auth.nav-group.branch')
        </ul>
    </div>
</aside>
