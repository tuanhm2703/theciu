@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link page-link-prev"
                    href="{{ $paginator->previousPageUrl() }}" aria-label="Previous" tabindex="-1" aria-disabled="true">
                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Trước
                </a>
            </li>
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><a class="page-link"
                                    href="#">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link page-link-next" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    Tiếp theo <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
@endif
