{{-- <div class="header-top">
    <div class="container">
        <div class="header-left">
            <ul class="top-menu top-link-menu d-none d-md-block">
                <li>
                    <a href="#">Links</a>
                    <ul>
                        <li><a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a></li>
                    </ul>
                </li>
            </ul><!-- End .top-menu -->
        </div><!-- End .header-left -->

        <div class="header-right">
            <div class="social-icons social-icons-color">
                <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i
                        class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i
                        class="icon-twitter"></i></a>
                <a href="#" class="social-icon social-pinterest" title="Instagram" target="_blank"><i
                        class="icon-pinterest-p"></i></a>
                <a href="#" class="social-icon social-instagram" title="Pinterest" target="_blank"><i
                        class="icon-instagram"></i></a>
            </div><!-- End .soial-icons -->

            <div class="header-dropdown">
                <a href="#">USD</a>
                <div class="header-menu">
                    <ul>
                        <li><a href="#">Eur</a></li>
                        <li><a href="#">Usd</a></li>
                    </ul>
                </div><!-- End .header-menu -->
            </div><!-- End .header-dropdown -->

            <div class="header-dropdown">
                <a href="#">Eng</a>
                <div class="header-menu">
                    <ul>
                        <li><a href="#">English</a></li>
                        <li><a href="#">French</a></li>
                        <li><a href="#">Spanish</a></li>
                    </ul>
                </div><!-- End .header-menu -->
            </div><!-- End .header-dropdown -->

            @if (auth('customer')->check())
                <div class="header-dropdown">
                    <a class="pr-4" href="{{ route('client.auth.profile.index') }}"><i class="icon-user"></i></a>
                    <div class="header-menu">
                        <ul>
                            <li>
                                {!! Form::open([
                                    'url' => route('client.auth.logout'),
                                    'method' => 'POST',
                                ]) !!}
                                <button type="submit" class="btn justify-content-start" href="#">Đăng xuất</button>
                                {!! Form::close() !!}
                            </li>
                            <li>
                                <a href="{{ route('client.auth.profile.order.index') }}">Đơn đã mua</a>
                            </li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->
            @else
                <ul class="top-menu top-link-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            @endif
        </div><!-- End .header-right -->
    </div>
</div> --}}
