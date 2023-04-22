<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#rank-collapse" aria-expanded="{{ isNavActive('admin.rank') ? 'true' : 'false' }}">
            <i class="opacity-6 fas fa-crown"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">
                {{ trans('nav.rank') }}</h6>
        </div>
        <div class="collapse {{ isNavActive('admin.rank') ? 'show' : 'hide' }}" id="rank-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @can('view rank')
                    <a class="nav-link {{ isNavActive('admin.rank.index') ? 'active' : '' }}"
                        href="{{ route('admin.rank.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('labels.rank') }}</span>
                    </a>
                @endcan
            </ul>
        </div>
    </li>
</ul>
