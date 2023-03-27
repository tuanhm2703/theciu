<!DOCTYPE html>
<html lang="en">

<head>
    @include('landingpage.layouts.meta')
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
    <link rel="stylesheet" href="{{ asset('assets/landingpage/vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/floating-labels.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bs4Toast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/tata.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magiczoomplus.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Mulish:wght@500&family=Roboto:ital,wght@0,300;1,300&display=swap"
        rel="stylesheet">
    <script src="{{ asset('assets/landingpage/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    @stack('css')
    @livewireStyles
</head>

<body>
    <div class="page-wrapper">

        @include('landingpage.layouts.components.header')

        <main class="main">
            @yield('content')
        </main>

        @include('landingpage.layouts.footer')
    </div><!-- End .page-wrapper -->
    <div class="mobile-menu-overlay">
    </div><!-- End .mobil-menu-overlay -->
    @include('landingpage.layouts.components.header-bottom-phone')

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
                                        aria-selected="true">{{ trans('labels.login') }}</a>
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

    <livewire:client.voucher-popup-component/>
    <div id="test-popup" class="white-popup mfp-hide">
        <livewire:client.product-detail-info-component></livewire:client.product-detail-info-component>
    </div>
    <x-dynamic-modal></x-dynamic-modal>
    <!-- Plugins JS File -->
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
    <!-- Main JS File -->
    <script src="{{ asset('assets/landingpage/js/main.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/demos/demo-6.js') }}"></script>
    <script src="{{ asset('assets/landingpage/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.lazyload.js') }}"></script>
    <script src="{{ asset('assets/landingpage/api-service.js') }}"></script>
    <script src="{{ asset('assets/landingpage/cart.js') }}"></script>
    <script src="{{ asset('assets/js/bs4Toast.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tata/tata.js') }}"></script>
    <script src="{{ asset('assets/js/magiczoomplus.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    @stack('js')
    <script>
        $('.lazy').lazyload();
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a[data-toggle=modal]', (e) => {
                e.preventDefault();
                $($(e.target).data('target')).modal('show')
            })
            $('body').on('click', 'button[data-toggle=modal]', (e) => {
                e.preventDefault();
                $($(e.target).data('target')).modal('show')
            })
        })
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (message, component) => {
                $('[data-toggle="tooltip"]').tooltip()
            })
        })
        window.addEventListener('openLoginForm', (e) => {
            openLoginModal()
        });
        window.addEventListener('openQuickPreview', (e) => {
            $.magnificPopup.open({
                items: {
                    src: $("#test-popup"),
                    type: "inline",
                },
            });
            try {
                $('.quickView-content .owl-carousel').owlCarousel('destroy')
            } catch (error) {}
            owlCarousels($('.quickView-content'), {
                onTranslate: function(e) {
                    var $this = $(e.target),
                        currentIndex = ($this.data('owl.carousel').current() + e.item
                            .count - Math.ceil(e.item.count / 2)) % e.item.count;
                    $('.quickView-content .carousel-dot').eq(currentIndex).addClass(
                        'active').siblings().removeClass('active');
                }
            });
            var swiper = new Swiper(".mySwiper", {
                direction: "vertical",
                slidesPerView: 4,
                spaceBetween: 0,
                loop: true,
                mousewheel: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                }
            });
            if ($("[data-bs-toggle=tooltip]").length) {
                $("[data-bs-toggle=tooltip]").tooltip({
                    html: true
                });
            }
        });
        window.addEventListener('openToast', (e) => {
            const type = e.detail.type
            const label = type == 'success' ? `{{ trans('toast.action_successful') }}` :
                `{{ trans('toast.action_failed') }}`
            tata[e.detail.type](label, e.detail.message)
        });
        window.addEventListener("initQuantityInput", (e) => {
            quantityInputs()
        });
        if ($("[data-bs-toggle=tooltip]").length) {
            $("[data-bs-toggle=tooltip]").tooltip({
                html: true
            });
        }
    </script>
    <livewire:scripts />
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->


    <div id="sticky-gift-icon">
        <div class="my-btn-border"></div>
        <img src="/img/gift-icon.png" class="btn-bell" alt="">
    </div>

    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "108168607735167");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v16.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</body>

</html>
