<!DOCTYPE html>
<html lang="en">

<head>
    @include('landingpage.layouts.meta')
    <link rel="stylesheet"
        href="{{ getAssetUrl('assets/landingpage/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/plugins/jquery.countdown.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/style.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/skins/skin-demo-6.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/demos/demo-6.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/client/app.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/landingpage/css/floating-labels.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/bs4Toast.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/admin/tata.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/magiczoomplus.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/notyf.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/client/wpmap.css') }}">
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/filepond/filepond.css') }}">
    <link rel="stylesheet" href="https://nielsboogaard.github.io/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.css">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Mulish:wght@500&family=Roboto:ital,wght@0,300;1,300&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ getAssetUrl('assets/css/scrollpagination.css') }}">

    <!-- JS -->
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/jquery.form.min.js') }}"></script>
    @stack('css')
    <style>
        .filepond--credits {
            display: none !important;
        }
        body {
            overflow-x: visible !important;
        }
        html:has(.modal-open),html:has(.mfp-ready) {
            height: 100vh;
            overflow-y: hidden;
        }
    </style>
    {!! App::get('WebsiteSetting')->data['header_code'] !!}
    @livewireStyles
</head>

<body>
    <div class="page-wrapper">

        @include('landingpage.layouts.components.header')

        <main class="main">
            @yield('content')
        </main>
        <livewire:client.footer-component />
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

    <x-dynamic-modal></x-dynamic-modal>
    <!-- Plugins JS File -->
    <script src="{{ getAssetUrl('assets/landingpage/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/superfish.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/owl.carousel.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/jbvalidator.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ getAssetUrl('assets/landingpage/js/main.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/demos/demo-6.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/jquery.lazyload.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/api-service.js') }}"></script>
    <script src="{{ getAssetUrl('assets/landingpage/cart.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/bs4Toast.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/plugins/tata/tata.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/magiczoomplus.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/notyf.min.js') }}"></script>
    <script src="{{ getAssetUrl('assets/js/plugins/multiple-image-video.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="{{ getAssetUrl('assets/js/jquery.star-rating.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/js/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('assets/js/scrollpagination.js') }}"></script>
    <script src="https://nielsboogaard.github.io/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>



    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginMediaPreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        const toast = {
            success: (title = '', content) => {
                var notyf = new Notyf();
                notyf.open({
                    type: 'success',
                    message: content,
                    background: '#c96'
                });
            },
            error: (title, content) => {
                var notyf = new Notyf();
                notyf.error(content);
            }
        }
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
        $('body').on('click', '.open-detail-voucher-btn', (e) => {
            const element = $(`.voucher-condition-detail[data-voucher-id=${$(e.target).attr('data-voucher-id')}]`)
            if (element.hasClass('show')) {
                element.removeClass('show')
            } else {
                element.addClass('show')
            }
        })
        $('body').on('click', '#sticky-gift-icon, #close-voucher-list-btn', (e) => {
            if ($('#save-voucher-component-wrapper').hasClass('hide')) {
                $('#save-voucher-component-wrapper').removeClass('hide')
            } else {
                $('#save-voucher-component-wrapper').addClass('hide')
            }
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
            MagicZoom.refresh();
        });
        window.addEventListener('openToast', (e) => {
            const type = e.detail.type
            const label = type == 'success' ? `{{ trans('toast.action_successful') }}` :
                `{{ trans('toast.action_failed') }}`
            toast[type](label, e.detail.message);
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


    @if (!isset($showFooterComponent))
        <livewire:client.sticky-voucher-icon-component />
        <livewire:client.list-saved-voucher-component />
        <div id="test-popup" class="white-popup mfp-hide">
            <livewire:client.product-detail-info-component />
        </div>
    @endif

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
    {!! App::get('WebsiteSetting')->data['footer_code'] !!}

    @stack('js')
</body>

</html>
