<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#product-collapse" aria-expanded="{{ isNavActive('admin.product') ? 'true' : 'false' }}">
            <i class="opacity-6 fas fa-box"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0" data-bs-toggle="tooltip"
                data-bs-placement="top" title='{{ trans('nav.product_manager') }}'>
                {{ trans('nav.product_manager') }} </h6>
        </div>
        <div class="collapse {{ isNavActive('admin.product') ? 'show' : 'hide' }}" id="product-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @can('create product')
                    <a class="nav-link {{ isNavActive('admin.product.create') ? 'active' : '' }}"
                        href="{{ route('admin.product.create') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.create_product') }}</span>
                    </a>
                @endcan
                @can('view product')
                    <a class="nav-link {{ isNavActive('admin.product.index') ? 'active' : '' }}"
                        href="{{ route('admin.product.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.product_list') }}</span>
                    </a>
                @endcan
            </ul>
        </div>
    </li>
</ul>
