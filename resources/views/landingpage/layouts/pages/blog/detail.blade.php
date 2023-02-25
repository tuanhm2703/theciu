@extends('landingpage.layouts.app', ['metaTags' => $blog->getMetaTags()])
@section('content')
    <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{ $blog->title }}
                {{-- <span>Single Post</span> --}}
            </h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <article class="entry single-entry">
                        <figure class="entry-media">
                            <img src="{{ optional($blog->image)->path_with_domain }}" alt="image desc">
                        </figure><!-- End .entry-media -->

                        <div class="entry-body">
                            <div class="entry-meta">
                                <span class="entry-author">
                                    by <a href="#">{{ $blog->author->name }}</a>
                                </span>
                                <span class="meta-separator">|</span>
                                <a href="#">{{ $blog->publish_date }}</a>
                                <span class="meta-separator">|</span>
                                {{-- <a href="#">2 Comments</a> --}}
                            </div><!-- End .entry-meta -->

                            <h2 class="entry-title">
                                {{ $blog->title }}
                            </h2><!-- End .entry-title -->

                            <div class="entry-cats">
                                @php
                                    $arr = array_map(function ($category) {
                                        return "<a href='#'>" . $category['name'] . '</a>';
                                    }, $blog->categories->toArray());
                                @endphp
                                in
                                {!! implode(', ', $arr) !!}
                            </div><!-- End .entry-cats -->

                            <div class="entry-content editor-content">
                                <p>{{ $blog->description }}
                                </p>

                                {!! $blog->content !!}
                            </div><!-- End .entry-content -->

                            <div class="entry-footer row no-gutters flex-column flex-md-row">
                                <div class="col-md">
                                    <div class="entry-tags">
                                        <span>Tags:</span> <a href="#">photography</a> <a href="#">style</a>
                                    </div><!-- End .entry-tags -->
                                </div><!-- End .col -->

                                <div class="col-md-auto mt-2 mt-md-0">
                                    <div class="social-icons social-icons-color">
                                        <span class="social-label">Share this post:</span>
                                        <a href="#" class="social-icon social-facebook" title="Facebook"
                                            target="_blank"><i class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon social-twitter" title="Twitter"
                                            target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon social-pinterest" title="Pinterest"
                                            target="_blank"><i class="icon-pinterest"></i></a>
                                        <a href="#" class="social-icon social-linkedin" title="Linkedin"
                                            target="_blank"><i class="icon-linkedin"></i></a>
                                    </div><!-- End .soial-icons -->
                                </div><!-- End .col-auto -->
                            </div><!-- End .entry-footer row no-gutters -->
                        </div><!-- End .entry-body -->
                        {{-- @include('landingpage.layouts.pages.blog.components.detail.author_detail') --}}

                    </article><!-- End .entry -->

                    {{-- <nav class="pager-nav" aria-label="Page navigation">
                        <a class="pager-link pager-link-prev" href="#" aria-label="Previous" tabindex="-1">
                            Previous Post
                            <span class="pager-link-title">Cras iaculis ultricies nulla</span>
                        </a>

                        <a class="pager-link pager-link-next" href="#" aria-label="Next" tabindex="-1">
                            Next Post
                            <span class="pager-link-title">Praesent placerat risus</span>
                        </a>
                    </nav><!-- End .pager-nav --> --}}

                    <livewire:client.related-blog-component :blog="$blog"></livewire:client.related-blog-component>
                    {{-- @include('landingpage.layouts.pages.blog.components.detail.comments')
                    @include('landingpage.layouts.pages.blog.components.detail.reply') --}}
                </div><!-- End .col-lg-9 -->
                @include('landingpage.layouts.pages.blog.components.detail.sidebar')
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
