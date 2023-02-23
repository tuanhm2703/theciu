@can('view promotion')
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                data-bs-target="#promotion-collapse" aria-expanded="{{ isNavActive('admin.promotion') ? 'true' : 'false' }}">
                <i class="opacity-6 far fas fa-tags"></i>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0" data-bs-toggle="tooltip"
                    data-bs-placement="top" title='{{ trans('nav.promotion_manager') }}'>

                    {{ trans('nav.promotion_manager') }}</h6>
            </div>
            <div class="collapse {{ isNavActive('admin.promotion') ? 'show' : 'hide' }}" id="promotion-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <a class="nav-link {{ isNavActive('admin.promotion.index') ? 'active' : '' }}"
                        href="{{ route('admin.promotion.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.promotion_list') }}</span>
                    </a>
                </ul>
            </div>
        </li>
    </ul>
@endcan
