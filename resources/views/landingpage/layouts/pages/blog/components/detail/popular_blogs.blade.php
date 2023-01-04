<div class="widget">
    <h3 class="widget-title">Popular Posts</h3><!-- End .widget-title -->
    <ul class="posts-list">
        @foreach ($popular_blogs as $p_blog)
            <li>
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <figure class="m-0">
                            <a href="#">
                                <img src="{{ optional($p_blog->image)->path_with_domain }}" alt="post">
                            </a>
                        </figure>
                    </div>
                    <div class="col-md-8">
                        <span>{{ $p_blog->publish_date }}</span>
                        <h4><a href="{{ route('client.blog.details', $p_blog->slug) }}">{{ $p_blog->title }}</a></h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul><!-- End .posts-list -->
</div><!-- End .widget -->
