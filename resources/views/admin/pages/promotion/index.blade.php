@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('nav.create_promotion')])
@push('style')
    @include('admin.pages.promotion.assets.style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.create_promotion')])
    <div class="container-fluid">
        <div style="min-height: 50vh">
            <div class="row d-flex align-items-stretch">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body p-3">
                            <div class="row h-100">
                                <div class="col-10">
                                    <div class="numbers">
                                        <h5 class="font-weight-bolder">Chương trình khuyến mãi</h5>
                                        <p class="mb-0">
                                            Tạo chương trình <span class="text-success text-sm font-weight-bolder">Giảm giá
                                                sản phẩm</span>
                                            trong khung thời gian
                                        </p>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle text-white">
                                        <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M30.995 16.365l3.148 4.923c.154.241.201.539.129.818L29.746 39.5c-.28 1.079-1.357 1.719-2.404 1.43l-8.887-2.453c-1.047-.29-1.668-1.398-1.388-2.476l4.526-17.395c.072-.28.257-.513.508-.642l5.116-2.643c1.334-.689 2.957-.24 3.778 1.043zm4.582 7.157l2.387 12.644c.206 1.095-.488 2.157-1.552 2.37l-5.001 1 4.166-16.014zM27.9 25.424h-.757l-4.04 7.634h.773l4.024-7.634zm.035 3.77c-.512 0-.948.186-1.31.557a1.864 1.864 0 0 0-.543 1.352c0 .527.18.977.543 1.35.362.372.798.559 1.31.559a1.76 1.76 0 0 0 1.31-.56c.362-.372.543-.822.543-1.349s-.181-.976-.543-1.35a1.76 1.76 0 0 0-1.31-.558zm0 1.093c.219 0 .406.08.56.239a.798.798 0 0 1 .232.577.798.798 0 0 1-.232.577.752.752 0 0 1-.56.239.752.752 0 0 1-.56-.239.798.798 0 0 1-.232-.577c0-.226.077-.418.231-.577a.752.752 0 0 1 .56-.239zm-4.841-4.827a1.76 1.76 0 0 0-1.31.56 1.867 1.867 0 0 0-.543 1.348c0 .527.18.977.543 1.35.362.372.798.559 1.31.559.514 0 .952-.187 1.312-.56.36-.372.54-.822.54-1.349 0-.526-.18-.976-.543-1.349a1.76 1.76 0 0 0-1.31-.559zm0 1.093c.219 0 .405.08.56.238a.798.798 0 0 1 .231.577.798.798 0 0 1-.231.578.752.752 0 0 1-.56.238.752.752 0 0 1-.56-.238.798.798 0 0 1-.232-.578c0-.225.077-.418.231-.577a.752.752 0 0 1 .56-.238zm3.248-7.977c-.28 1.078.341 2.186 1.388 2.475 1.047.29 2.123-.35 2.404-1.429.28-1.078-.341-2.187-1.388-2.476-1.047-.289-2.123.351-2.404 1.43z"
                                                fill-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <a class="btn btn-primary mb-0 align-self-end mt-3 me-2"
                                        href="{{ route('admin.promotion.create', ['type' => App\Enums\PromotionType::DISCOUNT]) }}"
                                        style="height: fit-content">
                                        Tạo ngay!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body p-3">
                            <div class="row h-100">
                                <div class="col-10">
                                    <div class="numbers">
                                        <h5 class="font-weight-bolder">Mã giảm giá</h5>
                                        <p class="mb-0">
                                            Tạo <span class="text-success text-sm font-weight-bolder">mã giảm giá</span>
                                            trong khung thời gian
                                        </p>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle text-white">
                                        <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M22 19v3.25a.75.75 0 0 0 1.493.102l.007-.102V19H39a2 2 0 0 1 2 2v3.4c-1.972 0-3.571 1.612-3.571 3.6 0 1.924 1.497 3.496 3.381 3.595l.19.005V35a2 2 0 0 1-2 2H23.5v-3.25a.75.75 0 0 0-.648-.743L22.75 33a.75.75 0 0 0-.743.648L22 33.75V37h-4a2 2 0 0 1-2-2v-3.4c1.972 0 3.571-1.612 3.571-3.6S17.972 24.4 16 24.4V21a2 2 0 0 1 2-2h4zm.75 6a.75.75 0 0 0-.743.648L22 25.75v4.5a.75.75 0 0 0 1.493.102l.007-.102v-4.5a.75.75 0 0 0-.75-.75z"
                                                fill-rule="evenodd" opacity=".96"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <a href="{{ route('admin.promotion.voucher.create') }}"
                                        class="btn btn-primary mb-0 align-self-end mt-3 me-2" style="height: fit-content">
                                        Tạo ngay!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body p-3">
                            <div class="row h-100">
                                <div class="col-10">
                                    <div class="numbers">
                                        <h5 class="font-weight-bolder">Chương trình flash sale</h5>
                                        <p class="mb-0">
                                            Tạo <span class="text-success text-sm font-weight-bolder">chương trình flash
                                                sale</span>
                                            trong khung thời gian ngắn
                                        </p>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle text-white">
                                        <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M33.665 25.495l.138.107a4.492 4.492 0 0 0 2.697.898l.212-.005a4.475 4.475 0 0 0 1.788-.463V37a2 2 0 0 1-2 2h-17a2 2 0 0 1-2-2V26.032c.602.3 1.281.468 2 .468l.213-.005a4.491 4.491 0 0 0 2.484-.893l.137-.107.137.107a4.492 4.492 0 0 0 2.698.898l.22-.005a4.492 4.492 0 0 0 2.558-.955l.052-.043.054.043c.772.606 1.741.96 2.778.96l.214-.005a4.491 4.491 0 0 0 2.484-.893l.136-.107zM29.081 29h-2.429l-1.208 4.515h1.36l-.937 3.795 3.799-5.676h-1.512L29.08 29zm7.143-12a2 2 0 0 1 1.814 1.157l1.22 2.626h-.015a3 3 0 0 1-5.577 2.203 3.001 3.001 0 0 1-5.666.008 3.001 3.001 0 0 1-5.666-.008 3.001 3.001 0 1 1-5.503-2.357l1.134-2.465A2 2 0 0 1 19.782 17h16.442z"
                                                fill-rule="evenodd" opacity=".96"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <a href="{{ route('admin.promotion.create', ['type' => App\Enums\PromotionType::FLASH_SALE]) }}"
                                        class="btn btn-primary mb-0 align-self-end mt-3 me-2" style="height: fit-content">
                                        Tạo ngay!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card h-100">
                        <div class="card-body p-3">
                            <div class="row h-100">
                                <div class="col-10">
                                    <div class="numbers">
                                        <h5 class="font-weight-bolder">Chương trình quà tặng đi kèm</h5>
                                        <p class="mb-0">
                                            Tạo <span class="text-success text-sm font-weight-bolder">chương trình quà tặng đi kèm</span>
                                            với giá trị đơn hàng tối thiểu
                                        </p>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle text-white">
                                        <i class="fas fa-gifts" style="opacity: 1"></i>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <a href="{{ route('admin.promotion.create', ['type' => App\Enums\PromotionType::ACCOM_GIFT]) }}"
                                        class="btn btn-primary mb-0 align-self-end mt-3 me-2" style="height: fit-content">
                                        Tạo ngay!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="promotion-product-tab" data-toggle="tab"
                                    href="#promotion-product" role="tab" aria-controls="home" aria-selected="true">
                                    Danh sách chương trình</a>
                            </li>
                            <li class="nav-item">
                                <a class="text-primary nav-link" id="flashsale-product-tab" data-toggle="tab"
                                    href="#flashsale-product" role="tab" aria-controls="profile" aria-selected="false">
                                    Danh sách sản phẩm flashsale</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="voucher-list-tab" data-toggle="tab" href="#voucher-list"
                                    role="tab" aria-controls="profile" aria-selected="false">
                                    Danh sách mã khuyến mãi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="accom-gift-tab" data-toggle="tab" href="#accom-gift"
                                    role="tab" aria-controls="profile" aria-selected="false">
                                    Danh sách chương trình tặng kèm</a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="promotion-product" role="tabpanel"
                            aria-labelledby="promotion-product-tab">
                            <div class="table-responsive">
                                <table class="promotion-table table w-100">
                                    <thead>
                                        <th style="padding-left: 0.5rem">
                                            No.
                                        </th>
                                        <th>{{ trans('labels.promotion_name') }}</th>
                                        <th>Trạng thái</th>
                                        <th>{{ trans('labels.time') }}</th>
                                        <th>{{ trans('labels.action') }}</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="flashsale-product" role="tabpanel"
                            aria-labelledby="flashsale-product-tab">
                            <div class="table-responsive">
                                <table class="flash-sale-table table w-100">
                                    <thead>
                                        <th style="padding-left: 0.5rem">
                                            No.
                                        </th>
                                        <th>{{ trans('labels.promotion_name') }}</th>
                                        <th>Trạng thái</th>
                                        <th>{{ trans('labels.time') }}</th>
                                        <th>{{ trans('labels.action') }}</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="voucher-list" role="tabpanel" aria-labelledby="voucher-list-tab">
                            @include('admin.pages.promotion.voucher.components.table')
                        </div>
                        <div class="tab-pane" id="accom-gift" role="tabpanel"
                            aria-labelledby="accom-gift-tab">
                            <div class="table-responsive">
                                <table class="accom-gift-table table w-100">
                                    <thead>
                                        <th style="padding-left: 0.5rem">
                                            No.
                                        </th>
                                        <th>{{ trans('labels.promotion_name') }}</th>
                                        <th>Trạng thái</th>
                                        <th>Giá trị đơn hàng tối thiểu</th>
                                        <th>{{ trans('labels.time') }}</th>
                                        <th>{{ trans('labels.action') }}</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    @include('admin.pages.promotion.voucher.assets._script')
@endpush
