<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#page-collapse" aria-expanded="{{ isNavActive('admin.page') ? 'true' : 'false'}}">
            <i class="opacity-6 far fa-list-alt"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">{{ trans('nav.page_management') }}</h6>
        </div>
        <div class="collapse {{ isNavActive('admin.page') ? 'show' : 'hide' }}" id="page-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <a class="nav-link {{ isNavActive('admin.page.index') ? 'active' : '' }}" href="{{ route('admin.page.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('labels.page_list') }}</span>
                </a>
            </ul>
        </div>
    </li>
</ul>
