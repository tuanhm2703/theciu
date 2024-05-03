<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#setting-collapse" aria-expanded="{{ isNavActive('admin.setting') ? 'true' : 'false' }}">
            <i class="opacity-6 far fas fa-cog"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">
                {{ trans('nav.setting') }}</h6>
        </div>
        <div class="collapse {{ isNavActive('admin.setting') ? 'show' : 'hide' }}" id="setting-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @can('view setting')
                    <a class="nav-link {{ isNavActive('admin.setting.website.index') ? 'active' : '' }}"
                        href="{{ route('admin.setting.website.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">Website</span>
                    </a>
                @endcan
                @can('view address')
                    <a class="nav-link {{ isNavActive('admin.setting.address.index') ? 'active' : '' }}"
                        href="{{ route('admin.setting.address.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.pickup_address') }}</span>
                    </a>
                @endcan
                <a class="nav-link {{ isNavActive('admin.setting.seo.index') ? 'active' : '' }}"
                    href="{{ route('admin.setting.seo.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('nav.seo_management') }}</span>
                </a>
                @can('view warehouse')
                    <a class="nav-link {{ isNavActive('admin.setting.warehouse.index') ? 'active' : '' }}"
                        href="{{ route('admin.setting.warehouse.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.sync_warehouse') }}</span>
                    </a>
                @endcan
                @can('view user')
                    <a class="nav-link {{ isNavActive('admin.setting.staff.index') ? 'active' : '' }}"
                        href="{{ route('admin.setting.staff.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.staff_management') }}</span>
                    </a>
                @endcan
                @can('view setting')
                    <a class="nav-link {{ isNavActive('admin.setting.shopee.index') ? 'active' : '' }}"
                        href="{{ route('admin.setting.shopee.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">Shopee</span>
                    </a>
                @endcan
            </ul>
        </div>
    </li>
</ul>
