<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ isset($headTitle) ? env('APP_NAME') . " - $headTitle" : env('APP_NAME') }}</title>
    <meta property="og:image" content="/img/logo-dark.png" />
    <meta name="keywords" content="HTML5 Template">
    <meta name="description"
        content="{{ isset($metaDescription) ? $metaDescription : 'Thời trang nữ THE CIU mang phong cách trẻ trung, năng động. Chuyên sản phẩm kết hợp đi học, đi chơi như áo thun, áo khoác, quần jean, đầm, chân váy.' }}">
    <meta name="author" content="p-themes">
    <meta name="locale" content="{{ App::getLocale() }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/landingpage/images/icons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('assets/landingpage/images/icons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/landingpage/images/icons/safari-pinned-tab.svg') }}" color="#666666">
    <link rel="icon" type="image/png" href="{{ asset('img/ciu-favicon.png') }}">
    <meta name="apple-mobile-web-app-title" content="THE C.I.U">
    <meta name="application-name" content="THE C.I.U">
    <meta name="locale" content="{{ App::getLocale() }}">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{ asset('assets/landingpage/images/icons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet"
        href="{{ asset('assets/landingpage/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/plugins/jquery.countdown.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/skins/skin-demo-6.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/demos/demo-6.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/client/app.css') }}">
    @stack('css')
</head>

<body>
    <div class="page-wrapper">
        <header class="header header-6">
            @include('landingpage.layouts.components.header')
        </header><!-- End .header -->

        <main class="main">
            @yield('content')
        </main>

        @include('landingpage.layouts.footer')
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->


    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                        role="tab" aria-controls="signin"
                                        aria-selected="true">{{ trans('labels.signin') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                        role="tab" aria-controls="register"
                                        aria-selected="false">{{ trans('labels.register') }}</a>
                                </li>
                            </ul>
                            @include('landingpage.layouts.components.login')
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ asset('assets/landingpage/images/popup/newsletter/logo.png') }}"
                                class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the THE C.I.U eCommerce newsletter to receive timely updates from your
                                favorite
                                products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white"
                                        placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- .End .input-group -->
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup
                                    again</label>
                            </div><!-- End .custom-checkbox -->
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ asset('assets/landingpage/images/popup/newsletter/img-1.jpg') }}"
                            class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Plugins JS File -->
    <script src="{{ asset('assets/landingpage/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/superfish.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jbvalidator.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('assets/landingpage/js/main.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/demos/demo-6.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.lazyload.js') }}"></script>
    <script src="{{ asset('assets/landingpage/api-service.js') }}"></script>
    <script src="{{ asset('assets/landingpage/cart.js') }}"></script>
    @stack('js')
    <script>
        $('.lazy').lazyload();
        // $(document).ajaxError(function(event, request, settings) {
        //     if (request.status === 401) {
        //         if (settings.url != @json(route('client.auth.login'))) {
        //             $('#signin-modal').modal('show')
        //         }
        //     }
        // });
    </script>
</body>

</html>
