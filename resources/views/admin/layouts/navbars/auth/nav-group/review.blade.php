<ul class="list-unstyled ps-0">
    <li class="mb-1">
        <div class="btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
            data-bs-target="#review-collapse" aria-expanded="{{ isNavActive('admin.review') ? 'true' : 'false' }}">
            <i class="opacity-6 fas fa-comment-dots"></i>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0" data-bs-toggle="tooltip"
                data-bs-placement="top" title='{{ trans('nav.review_manager') }}'>
                {{ trans('nav.review_manager') }} </h6>
        </div>
        <div class="collapse {{ isNavActive('admin.review') ? 'show' : 'hide' }}" id="review-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @can('view review')
                    <a class="nav-link {{ isNavActive('admin.review.index') ? 'active' : '' }}"
                        href="{{ route('admin.review.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        </div>
                        <span class="nav-link-text ms-1">{{ trans('nav.review_list') }}</span>
                    </a>
                @endcan
            </ul>
        </div>
    </li>
</ul>
