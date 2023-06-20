@extends('landingpage.layouts.app', ['headTitle' => 'Trang chủ'])
@section('content')
    <main class="main">
        <livewire:client.banner-slider-component />
        <div class="phone-swap">
            <div class="lazy">
                <livewire:new-arrival-component />
            </div>
            <div class="lazy">
                <livewire:client.featured-category-component />
            </div>
        </div>

        <div class="mb-5"></div><!-- End .mb-5 -->

        <livewire:client.deal-of-day-component />

        <div class="pt-4 pb-3" style="background-color: #222;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('client.page.details', 'thanh-toan') }}" class="d-block">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-rotate-left"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">{{ trans('labels.payment') }}</h3>
                                    <!-- End .icon-box-title -->
                                    </h3><!-- End .icon-box-title -->
                                    {{-- <p>Miễn phí cho đơn hàng 100k</p> --}}
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </a>
                    </div><!-- End .col-lg-3 col-sm-6 -->

                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('client.page.details', 'van-chuyen') }}" class="d-block">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-truck"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">{{ trans('labels.shipment') }}</h3>
                                    <!-- End .icon-box-title -->
                                    {{-- <p>Miễn phí 100% phí hoàn trả</p> --}}
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </a>
                    </div><!-- End .col-lg-3 col-sm-6 -->

                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('client.page.details', 'chinh-sach-bao-hanh-va-doi-san-pham') }}" class="d-block">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-unlock"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">{{ trans('labels.return_and_refund') }}</h3>
                                    <!-- End .icon-box-title -->
                                    {{-- <p>100% an toàn với phương thức thanh toán</p> --}}
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </a>
                    </div><!-- End .col-lg-3 col-sm-6 -->

                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('client.page.details', 'ho-tro-dich-vu') }}" class="d-block">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-headphones"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">{{ trans('labels.customer_service') }}</h3>
                                    <!-- End .icon-box-title -->
                                    {{-- <p>Dịch vụ hỗ trợ khách hàng 24/7</p> --}}
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </a>
                    </div><!-- End .col-lg-3 col-sm-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .bg-light pt-2 pb-2 -->

        <div class="mb-6"></div><!-- End .mb-5 -->
        <div class="container lazy">
            <livewire:client.best-seller-component />
        </div><!-- End .container -->
        <div class="mb-2"></div><!-- End .mb-5 -->

        <div class="lazy">
            <livewire:client.theciu-blog-component />
        </div>
    </main><!-- End .main -->
@endsection
@push('js')
@endpush
