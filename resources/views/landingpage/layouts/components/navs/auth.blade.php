@if (auth('customer')->check())
    <div class="dropdown cart-dropdown">
        <a href="{{ route('client.auth.profile.index') }}" class="dropdown-toggle" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" data-display="static">
            <i class="icon-user"></i>
        </a>

        <div class="dropdown-menu p-0" style="width: fit-content !important;">
            <div>
                {!! Form::open([
                    'url' => route('client.auth.logout'),
                    'method' => 'POST',
                ]) !!}
                <button type="submit" class="btn justify-content-start" href="#">Đăng xuất</button>
                {!! Form::close() !!}
            </div>
            <div>
                <a class="btn justify-content-start" href="{{ route('client.auth.profile.order.index') }}">Đơn đã mua</a>
            </div>

        </div><!-- End .dropdown-menu -->
    </div>
@else
    <div class="dropdown cart-dropdown">
        <ul class="top-menu top-link-menu">
            <li>
                <a href="#">Links</a>
                <ul>
                    <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user mr-1"></i>Login</a></li>
                </ul>
            </li>
        </ul>
    </div>
@endif
