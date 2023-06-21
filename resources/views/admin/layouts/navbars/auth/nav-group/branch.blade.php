@can('view branch')
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                data-bs-target="#branch-collapse" aria-expanded="{{ isNavActive('admin.branch') ? 'true' : 'false' }}">
                <i class="fas fa-store opacity-6"></i>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">{{ trans('nav.branch_management') }}
                </h6>
            </div>
            <div class="collapse {{ isNavActive('admin.branch') ? 'show' : 'hide' }}" id="branch-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <a class="nav-link {{ isNavActive('admin.branch.index') ? 'active' : '' }}"
                        href="{{ route('admin.branch.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('labels.branch_list') }}</span>
                    </a>
                </ul>
            </div>
        </li>
    </ul>
@endcan
