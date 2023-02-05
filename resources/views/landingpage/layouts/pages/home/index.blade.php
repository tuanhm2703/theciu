@extends('landingpage.layouts.app', ['headTitle' => 'Trang chủ'])
@section('content')
    <main class="main">
        @include('landingpage.layouts.components.banner-slider')
        @include('landingpage.layouts.pages.home.components.featured_category')
        <div class="mb-5"></div><!-- End .mb-5 -->
        <div class="container">
            @include('landingpage.layouts.pages.home.components.trending')
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- End .mb-5 -->

        @include('landingpage.layouts.pages.home.components.deal_of_day')

        <div class="pt-4 pb-3" style="background-color: #222;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="icon-box text-center">
                            <span class="icon-box-icon">
                                <i class="icon-truck"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Thanh toán và vận chuyển</h3><!-- End .icon-box-title -->
                                <p>Miễn phí cho đơn hàng 100k</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-3 col-sm-6 -->

                    <div class="col-lg-3 col-sm-6">
                        <div class="icon-box text-center">
                            <span class="icon-box-icon">
                                <i class="icon-rotate-left"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Trả hàng và hoàn tiền</h3><!-- End .icon-box-title -->
                                <p>Miễn phí 100% phí hoàn trả</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-3 col-sm-6 -->

                    <div class="col-lg-3 col-sm-6">
                        <div class="icon-box text-center">
                            <span class="icon-box-icon">
                                <i class="icon-unlock"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Thanh toán an toàn</h3><!-- End .icon-box-title -->
                                <p>100% an toàn với phương thức thanh toán</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-3 col-sm-6 -->

                    <div class="col-lg-3 col-sm-6">
                        <div class="icon-box text-center">
                            <span class="icon-box-icon">
                                <i class="icon-headphones"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Hỗ trợ dịch vụ</h3><!-- End .icon-box-title -->
                                <p>Dịch vụ hỗ trợ khách hàng 24/7</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-3 col-sm-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .bg-light pt-2 pb-2 -->

        <div class="mb-6"></div><!-- End .mb-5 -->
        <livewire:new-arrival-component></livewire:new-arrival-component>
        <div class="mb-2"></div><!-- End .mb-5 -->

        <div class="container">
        </div><!-- End .container -->

        <div class="blog-posts mb-5">
            <div class="container">
                <h2 class="title text-center mb-4">Bài viết</h2><!-- End .title text-center -->

                <div class="owl-carousel owl-simple mb-3" data-toggle="owl"
                    data-owl-options='{
                            "nav": false,
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                    @foreach ($blogs as $blog)
                        @component('components.client.blog-card', compact('blog'))
                        @endcomponent
                    @endforeach
                </div><!-- End .owl-carousel -->
            </div><!-- End .container -->
        </div><!-- End .blog-posts -->
    </main><!-- End .main -->
@endsection
