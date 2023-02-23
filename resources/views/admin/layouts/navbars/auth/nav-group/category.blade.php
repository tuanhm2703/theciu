@can('view category')
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                data-bs-target="#category-collapse" aria-expanded="{{ isNavActive('admin.category') ? 'true' : 'false' }}">
                <i class="opacity-6 far fa-list-alt"></i>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">{{ trans('nav.category_manager') }}
                </h6>
            </div>
            <div class="collapse {{ isNavActive('admin.category') ? 'show' : 'hide' }}" id="category-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <a class="nav-link {{ isNavActive('admin.category.index') ? 'active' : '' }}"
                        href="{{ route('admin.category.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.list_category') }}</span>
                    </a>
                    <a class="nav-link {{ isNavActive('admin.category.type', 'product') ? 'active' : '' }}"
                        href="{{ route('admin.category.type', 'product') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.product_category_list') }}</span>
                    </a>
                </ul>
            </div>
        </li>
    </ul>
@endcan
