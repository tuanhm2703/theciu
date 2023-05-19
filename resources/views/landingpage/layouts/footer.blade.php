<footer class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="widget widget-about">
                        <h4 class="widget-title">Chi nhánh</h4><!-- End .widget-title -->
                        <ul class="widget-list">
                            <li>
                                Alley 32 Nguyen Gia Tri, Binh Thanh District, HCM City <br>Hotline: 0901.246.912
                            </li>
                            <li>
                                73 Nguyen Van Bao, Go Vap District, HCM City <br>Hotline: 0707.987.912
                            </li>
                            <li>
                                680 Su Van Hanh, District 10, HCM City <br>Hotline: 0707.358.912
                            </li>
                            <li>
                                50 To Vinh Dien, Linh Chieu, Thu Duc, HCM City <br>Hotline: 0333.707.912
                            </li>
                        </ul>
                    </div><!-- End .widget about-widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">{{ trans('labels.information') }}</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            @foreach ($pages as $index => $page)
                                <li><a href="{{ route('client.page.details', $page->slug) }}"
                                        class="sf-with-ul">{{ $page->title }}</a></li>
                                @if ($index == 0)
                                    <li><a href="{{ route('client.blog.index') }}" target="_blank">Blog</a></li>
                                @endif
                                @if($index == $pages->count() - 2 || $pages->count() == 1)
                                    <li><a href="https://www.facebook.com/HR.THECIU" target="_blank">Tuyển dụng</a></li>
                                @endif
                            @endforeach
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">Social media</h4><!-- End .widget-title -->
                        <ul class="widget-list">
                            <li>
                                <a href="https://www.facebook.com/The.C.I.U.2016/" class="social-link" title="Facebook"
                                    target="_blank">
                                    <i class="icon-facebook-f"></i> Facebook
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/theciusaigon/" class="social-link" title="Instagram"
                                    target="_blank">
                                    <i class="icon-instagram"></i> Instagram
                                </a>
                            </li>
                            <li>
                                <a href="https://www.tiktok.com/@theciusaigon" class="social-link" title="Tiktok"
                                    target="_blank">
                                    <i>
                                        <svg style="fill: grey;" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512">
                                            <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                            <path
                                                d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z" />
                                        </svg>
                                    </i>
                                    Tiktok
                                </a>
                            </li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Phương thức thanh toán</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            @foreach ($payment_methods as $method)
                                <li>
                                    <a href="#">
                                        <img class="payment-logo d-inline" src="{{ $method->image->path_with_domain }}"
                                            alt="THE CIU PAYMENT METHOD - {{ $method->name }}">
                                        {{ trans('labels.payment_methods.' . $method->code) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul><!-- End .widget-list -->

                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .footer-middle -->

    <div class="footer-bottom">
        <div class="container">
            <div class="logo footer-logo">
                <img src="{{ asset('img/logo-white.png') }}" alt="THE CIU - LOGO" class="m-auto" width="82"
                    height="25">
            </div>
            <p class="footer-copyright">Copyright © 2019 THE C.I.U Store. All Rights Reserved.</p>
            <!-- End .footer-copyright -->
        </div><!-- End .container -->
    </div><!-- End .footer-bottom -->
</footer><!-- End .footer -->
