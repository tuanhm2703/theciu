<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#recruitment-collapse"
            aria-expanded="{{ isNavActive('admin.recruitment') ? 'true' : 'false' }}">

            <i class="opacity-6 fas fa-file-pdf"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0" data-bs-toggle="tooltip"
                data-bs-placement="top" title='{{ trans('nav.recruitment_manager') }}'>
                {{ trans('nav.recruitment_manager') }} </h6>
        </div>
        <div class="collapse {{ isNavActive('admin.recruitment') ? 'show' : 'hide' }}" id="recruitment-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @can('create recruitment')
                    <a class="nav-link {{ isNavActive('admin.recruitment.jd.index') ? 'active' : '' }}"
                        href="{{ route('admin.recruitment.jd.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.jd_list') }}</span>
                    </a>
                @endcan
                @can('view recruitment')
                    <a class="nav-link {{ isNavActive('admin.recruitment.resume.index') ? 'active' : '' }}"
                        href="{{ route('admin.recruitment.resume.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.resume_list') }}</span>
                    </a>
                @endcan
            </ul>
        </div>
    </li>
</ul>
