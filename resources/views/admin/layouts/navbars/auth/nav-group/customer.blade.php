@can('view customer')
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                data-bs-target="#customer-collapse" aria-expanded="{{ isNavActive('admin.customer') ? 'true' : 'false' }}">
                <i class="opacity-6 fas fa-users"></i>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">
                    {{ trans('nav.customer') }}</h6>
            </div>
            <div class="collapse {{ isNavActive('admin.customer') ? 'show' : 'hide' }}" id="customer-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <a class="nav-link {{ isNavActive('admin.customer.index') ? 'active' : '' }}"
                        href="{{ route('admin.customer.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.customer_list') }}</span>
                    </a>
                </ul>
            </div>
        </li>
    </ul>
@endcan
