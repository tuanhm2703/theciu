<article class="entry entry-list">
    <div class="row align-items-center">
        <div class="col-md-5">
            <figure class="entry-media">
                <a href="{{ route('client.blog.details', $blog->slug) }}">
                    <img src="{{ $blog->image->path_with_domain }}" alt="{{ $blog->slug }}">
                </a>
            </figure><!-- End .entry-media -->
        </div><!-- End .col-md-5 -->

        <div class="col-md-7">
            <div class="entry-body">
                <div class="entry-meta">
                    <span class="entry-author">
                        Tác giả: <a href="#">{{ $blog->author->name }}</a>
                    </span>
                    <span class="meta-separator">|</span>
                    <a href="#">{{ $blog->publish_date }}</a>
                    {{-- <span class="meta-separator">|</span> --}}
                    {{-- <a href="#">2 Comments</a> --}}
                </div><!-- End .entry-meta -->

                <h2 class="entry-title">
                    <a href="{{ route('client.blog.details', $blog->slug) }}">{{ $blog->title }}</a>
                </h2><!-- End .entry-title -->

                <div class="entry-cats">
                    @php
                        $arr = array_map(function ($category) {
                            return "<a href='#'>" . $category['name'] . '</a>';
                        }, $blog->categories->toArray());
                    @endphp
                    {!! implode(', ', $arr) !!}
                </div><!-- End .entry-cats -->

                <div class="entry-content">
                    <p>{{ $blog->description }}</p>
                    <a href="{{ route('client.blog.details', $blog->slug) }}" class="read-more">Đọc tiếp</a>
                </div><!-- End .entry-content -->
            </div><!-- End .entry-body -->
        </div><!-- End .col-md-7 -->
    </div><!-- End .row -->
</article>
<article class="entry">
