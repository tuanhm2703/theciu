<aside class="col-lg-3">
    <div class="sidebar">
        <div class="widget widget-search">
            <h3 class="widget-title">{{ trans('labels.search') }}</h3><!-- End .widget-title -->

            <form action="#">
                <label for="ws" class="sr-only">{{ trans('labels.search_in_blog') }}</label>
                <input type="search" class="form-control" name="ws" id="ws"
                    placeholder="{{ trans('labels.search_in_blog') }}" required>
                <button type="submit" class="btn"><i class="icon-search"></i><span
                        class="sr-only">{{ trans('labels.search') }}</span></button>
            </form>
        </div><!-- End .widget -->
        @php
            $blog = isset($blog) ? $blog : null;
        @endphp
        <livewire:client.blog-category-list-component></livewire:client.blog-category-list-component>
        <livewire:client.popular-post-component :blog="$blog"></livewire:client.popular-post-component>

        <div class="widget widget-banner-sidebar">
            <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->

            <div class="banner-sidebar">
                <a href="#">
                    <img src="{{ asset('assets/images/blog/sidebar/banner.jpg') }}" alt="banner">
                </a>
            </div><!-- End .banner-ad -->
        </div><!-- End .widget -->

        <div class="widget">
            <h3 class="widget-title">Browse Tags</h3><!-- End .widget-title -->

            <div class="tagcloud">
                <a href="#">fashion</a>
                <a href="#">style</a>
                <a href="#">women</a>
                <a href="#">photography</a>
                <a href="#">travel</a>
                <a href="#">shopping</a>
                <a href="#">hobbies</a>
            </div><!-- End .tagcloud -->
        </div><!-- End .widget -->

        <div class="widget widget-text">
            <h3 class="widget-title">About Blog</h3><!-- End .widget-title -->

            <div class="widget-text-content">
                <p>Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, pulvinar nunc
                    sapien ornare nisl.</p>
            </div><!-- End .widget-text-content -->
        </div><!-- End .widget -->
    </div><!-- End .sidebar sidebar-shop -->
</aside><!-- End .col-lg-3 -->
