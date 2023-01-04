<article class="entry">
    <figure class="entry-media">
        <a href="{{ route('client.blog.details', $blog->slug) }}">
            <img src="{{ $blog->image->path_with_domain }}" alt="image desc" class="lazy">
        </a>
    </figure><!-- End .entry-media -->

    <div class="entry-body text-center">
        <div class="entry-meta">
            <a href="#">{{ $blog->publish_date->format('D M, Y') }}</a>
        </div><!-- End .entry-meta -->

        <h3 class="entry-title">
            <a href="{{ route('client.blog.details', $blog->slug) }}">{{ $blog->title }}.</a>
        </h3><!-- End .entry-title -->

        <div class="entry-content">
            <a href="{{ route('client.blog.details', $blog->slug) }}" class="read-more">Xem thêm</a>
        </div><!-- End .entry-content -->
    </div><!-- End .entry-body -->
</article><!-- End .entry -->
