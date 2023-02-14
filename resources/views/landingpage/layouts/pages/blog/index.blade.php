@extends('landingpage.layouts.app')
@section('content')
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{ trans('labels.blog') }}<span>Blog</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{trans('labels.blog_list')}}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">

                    @foreach ($blogs as $blog)
                        @component('components.client.blog-big-card', compact('blog'))
                        @endcomponent
                    @endforeach
                    {!! $blogs->links('components.pagination') !!}

                </div><!-- End .col-lg-9 -->

                @include('landingpage.layouts.pages.blog.components.detail.sidebar')            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
