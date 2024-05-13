@if ($leftBlogs->count() > 0 && $rightBlogs->count() > 0)
<div class="my-5 container">
    <h2 class="title text-center mb-4">Blog</h2>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" style="overflow: hidden"
            data-owl-options='{
            "dots": false,
            "nav": false,
            "margin": 30,
            "autoplay": true,
            "autoplayTimeout": 3000,
            "items": 1,
            "loop": true,
        }'>
            @foreach ($leftBlogs as $blog)
                <article class="entry entry-mask">
                    <figure class="entry-media">
                        <a href="{{ $blog->detail_url }}" class="blog-thumbnail"
                            style="height: 400px; overflow: hidden; background-image: url({{ $blog->thumbnail }}); background-position: center; background-size: cover">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body">
                        <div class="entry-meta">
                            <a
                                href="{{ $blog->detail_url }}">{{ (new \Carbon\Carbon($blog->post_date))->format('M D Y') }}</a>
                            <span class="meta-separator">|</span>
                            <a href="{{ $blog->detail_url }}">{{ $blog->comment_count }} Comments</a>
                        </div><!-- End .entry-meta -->

                        <h2 class="entry-title">
                            <a href="{{ $blog->detail_url }}">{!! $blog->post_title !!}</a>
                        </h2><!-- End .entry-title -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->
            @endforeach
        </div>
        <div class="col-12 col-md-6 owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
            data-owl-options='{
        "dots": false,
        "nav": false,
        "margin": 30,
        "autoplay": true,
        "autoplayTimeout": 3000,
        "items": 1,
        "loop": true,
    }'
            style="height: 400px; overflow: hidden">
            @foreach ($rightBlogs->chunk(4) as $blogs)
                <ul class="posts-list">
                    @foreach ($blogs as $blog)
                        <li style="height: 85px; margin-bottom: 15px; overflow: hidden">
                            <figure>
                                <a href="{{ $blog->detail_url }}">
                                    <img src="{{ $blog->thumbnail }}" alt="post">
                                </a>
                            </figure>

                            <div>
                                <span>{{ (new \Carbon\Carbon($blog->post_date))->format('M D Y') }}</span>
                                <h4><a href="{{ $blog->detail_url }}">{{ $blog->post_title }}</a></h4>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('client.blog.index') }}" class="read-more">Xem thêm</a>
    </div>
</div>
@endif
