<li class="{{ isNavActive('client.product.sale_off') ? 'active' : '' }}">
    <a href="{{ route('client.product.sale_off') }}">Sale off</a>

    <div class="megamenu megamenu-sm">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="menu-col">
                    <ul>
                        @foreach ($promotions as $p)
                            <li>
                                <a
                                    href="{{ route('client.sale_off.index', $p->slug) }}">
                                    {{ $p->name }}<span><span class="tip tip-new">New</span></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div><!-- End .menu-col -->
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->
    </div><!-- End .megamenu megamenu-sm -->
</li>
