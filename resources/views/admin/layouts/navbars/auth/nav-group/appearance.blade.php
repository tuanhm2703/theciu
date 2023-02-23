<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#banner-collapse" aria-expanded="{{ isNavActive('admin.appearance') ? 'true' : 'false' }}">
            <i class="ni ni-image opacity-6"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">{{ trans('nav.content_manager') }}
            </h6>
        </div>
        <div class="collapse {{ isNavActive('admin.appearance') ? 'show' : 'hide' }}" id="banner-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @can('view banner')
                    <a class="nav-link {{ isNavActive('admin.appearance.banner.index') ? 'active' : '' }}"
                        href="{{ route('admin.appearance.banner.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.banner_list') }}</span>
                    </a>
                @endcan
                @can('view blog')
                    <a class="nav-link {{ isNavActive('admin.appearance.blog.index') ? 'active' : '' }}"
                        href="{{ route('admin.appearance.blog.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.blog_list') }}</span>
                    </a>
                @endcan
            </ul>
        </div>
    </li>
</ul>
