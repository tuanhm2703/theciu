@extends('landingpage.layouts.app')
@push('css')
    <style>
        .page-content-table thead tr th {
            font-size: 1.5em;
        }

        .page-content-table thead tr th {
            padding: 12px 0;
        }

        .page-content-table tbody tr td {
            font-size: 1.3em;
            padding: 2rem 5px;
            color: black;
            vertical-align: center;
        }

        .page-content-table tbody tr td.row-title {
            font-weight: bold;
            text-transform: uppercase;
            width: 20%;
            text-align: center;
        }

        .page-content-table ul {
            list-style-position: inside;
        }

        .page-content-table ul li::before {
            content: "\2022";
            color: black;
            font-weight: bold;
            display: inline-block;
            width: 1em;
        }
        .page-title {
            font-weight: bold;
            text-align: center;
            padding: 72px 0;
        }
        .section-title {
            color: #c96;
            font-weight: bold;
            text-transform: uppercase;
        }
        .section-content p {
            color: black !important;
        }
        .section-content {
            color: black;
            font-size: 1.5em;
            line-height: 2em;
            margin-bottom: 72px;
        }
        .section-content  ul li::before {
            content: "\2022";
            color: black;
            font-weight: bold;
            display: inline-block;
            width: 1em;
        }
    </style>
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active"><a
                        href="#">{{ trans('labels.payment_and_shipping') }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <h5 class="page-title">THANH TOÁN VÀ VẬN CHUYỂN</h5>
            <section class="payment-section">
                <h5 class="section-title">1. Thanh toán</h5>
                <div class="section-content">
                    <p>Với tiêu chí không ngừng nỗ lực để trải nghiệm mua hàng của Quý khách diễn ra thuận lợi hơn, The C.I.U hiện hỗ trợ 2 hình thức thanh toán tại Website như sau:</p>
                    <ul>
                        <li>Thanh toán khi nhận hàng (COD): quý khách nhận hàng, kiểm tra hàng và thanh toán trực tiếp cho nhân viên giao hàng</li>
                        <li>
                            Thanh toán Online: qua hình thức chuyển khoản hoặc ví điện tử <strong>Momo</strong>, <strong>VNPAY</strong>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="shipping-section">
                <h5 class="section-title">Vận chuyển</h5>
                <div class="section-content">
                    <ul>
                        <li>
                            Nội thành: 1-2 ngày (Tp.HCM)
                        </li>
                        <li>Ngoại thành và các tỉnh lân cận: 2-3 ngày</li>
                        <li>Các tỉnh miền Trung: 3-4 ngày</li>
                        <li>Các tỉnh miền Bắc: 3-5 ngày</li>
                    </ul>
                    <p>Lưu ý: Có thể phát sinh 1-2 ngày do Lễ Tết, thời tiết hoặc một số lỗi hệ thống trong quá trình giao hàng.</p>
                </div>
            </section>
        </div>
    </div>
@endsection
