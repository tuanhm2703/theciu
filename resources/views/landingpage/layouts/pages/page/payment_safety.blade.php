@extends('landingpage.layouts.app')
@push('css')
<style>
    .info-icon {
        flex: 0 0 3%;
        min-width: 50px;
    }
    .step-title {
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 2em;
    }
</style>
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active"><a
                        href="#">{{ trans('labels.payment_safety') }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <h5 class="page-title">Thanh toán an toàn</h5>
            <section class="payment-section">
                <h5 class="section-title">Thanh toán</h5>
                <div class="section-content">
                    <p>Với tiêu chí không ngừng nỗ lực để trải nghiệm mua hàng của Quý khách diễn ra thuận lợi hơn, The C.I.U hiện hỗ trợ 2 hình thức thanh toán tại Website như sau:</p>
                    <ul>
                        <li>
                            Thanh toán khi nhận hàng (COD): quý khách nhận hàng, kiểm tra hàng và thanh toán trực tiếp cho nhân viên giao hàng
                        </li>
                        <li>Thanh toán Online: qua hình thức chuyển khoản hoặc ví điện tử <strong>Momo, VNPAY</strong></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
@endsection
