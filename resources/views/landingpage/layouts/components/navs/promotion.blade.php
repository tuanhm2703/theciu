<li class="{{ isNavActive('client.product.sale_off') ? 'active' : '' }}">
    <a href="{{ route('client.product.sale_off') }}">Sale off
    </a>

    <div class="megamenu megamenu-sm">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="menu-col">
                    <ul>
                        @if ($available_combos->count() > 0)
                            <li>
                                <a
                                    href="{{ route('client.combo.index') }}">
                                    Combo khuyến mãi
                                    <span><span class="tip tip-hot" style="width: max-content">New</span></span>
                                </a>
                            </li>
                        @endif
                        @foreach ($promotions as $p)
                            <li>
                                <a href="{{ route('client.product.sale_off', $p->slug) }}">
                                    {{ $p->name }}
                                    @if (now()->isBefore($p->from))
                                        <span><span class="tip tip-new"
                                                style="width: max-content">{{ __('labels.comming_soon') }}</span></span>
                                    @else
                                        <span><span class="tip tip-hot"
                                                style="width: max-content">{{ __('labels.happenning') }}</span></span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div><!-- End .menu-col -->
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->
    </div><!-- End .megamenu megamenu-sm -->
</li>
