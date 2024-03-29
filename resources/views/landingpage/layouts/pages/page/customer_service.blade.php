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
                        href="#">{{ trans('labels.payment_and_shipping') }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <h5 class="page-title">Hỗ trợ dịch vụ</h5>
            <section class="payment-section">
                <h5 class="section-title">1. Thông tin liên hệ</h5>
                <div class="section-content">
                    <p>Mọi ý kiến của khách hàng vui lòng liên hệ:</p>
                    <p class="d-flex mt-2">
                        <span class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0.25C8.07164 0.25 6.18657 0.821828 4.58319 1.89317C2.97982 2.96451 1.73013 4.48726 0.992179 6.26884C0.254225 8.05042 0.061142 10.0108 0.437348 11.9021C0.813554 13.7934 1.74215 15.5307 3.10571 16.8943C4.46928 18.2579 6.20656 19.1865 8.09787 19.5627C9.98919 19.9389 11.9496 19.7458 13.7312 19.0078C15.5127 18.2699 17.0355 17.0202 18.1068 15.4168C19.1782 13.8134 19.75 11.9284 19.75 10C19.7473 7.41498 18.7192 4.93661 16.8913 3.10872C15.0634 1.28084 12.585 0.25273 10 0.25ZM7.52782 13.75H12.4722C11.9688 15.4694 11.125 17.0191 10 18.2397C8.875 17.0191 8.03125 15.4694 7.52782 13.75ZM7.1875 12.25C6.93876 10.7603 6.93876 9.23969 7.1875 7.75H12.8125C13.0613 9.23969 13.0613 10.7603 12.8125 12.25H7.1875ZM1.75 10C1.74935 9.23916 1.85442 8.48192 2.06219 7.75H5.66782C5.44407 9.24166 5.44407 10.7583 5.66782 12.25H2.06219C1.85442 11.5181 1.74935 10.7608 1.75 10ZM12.4722 6.25H7.52782C8.03125 4.53062 8.875 2.98094 10 1.76031C11.125 2.98094 11.9688 4.53062 12.4722 6.25ZM14.3322 7.75H17.9378C18.3541 9.22112 18.3541 10.7789 17.9378 12.25H14.3322C14.5559 10.7583 14.5559 9.24166 14.3322 7.75ZM17.3472 6.25H14.0256C13.6429 4.74392 13.0001 3.31623 12.1263 2.03125C13.2427 2.33127 14.2839 2.86162 15.1831 3.58818C16.0823 4.31475 16.8194 5.22146 17.3472 6.25ZM7.87375 2.03125C6.9999 3.31623 6.35713 4.74392 5.97438 6.25H2.65282C3.18056 5.22146 3.91772 4.31475 4.81689 3.58818C5.71606 2.86162 6.75733 2.33127 7.87375 2.03125ZM2.65282 13.75H5.97438C6.35713 15.2561 6.9999 16.6838 7.87375 17.9688C6.75733 17.6687 5.71606 17.1384 4.81689 16.4118C3.91772 15.6852 3.18056 14.7785 2.65282 13.75ZM12.1263 17.9688C13.0001 16.6838 13.6429 15.2561 14.0256 13.75H17.3472C16.8194 14.7785 16.0823 15.6852 15.1831 16.4118C14.2839 17.1384 13.2427 17.6687 12.1263 17.9688Z" fill="black"/>
                                </svg>
                        </span>
                        <span class="info-content">
                            Hotline: <a href="tel:0775.665.912">0775.665.912</a>
                        </span>
                    </p>
                    <p class="d-flex">
                        <span class="info-icon">
                            <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5C8.25832 5 7.5333 5.21993 6.91661 5.63199C6.29993 6.04404 5.81928 6.62971 5.53545 7.31494C5.25162 8.00016 5.17736 8.75416 5.32205 9.48159C5.46675 10.209 5.8239 10.8772 6.34835 11.4017C6.8728 11.9261 7.54098 12.2833 8.26841 12.4279C8.99584 12.5726 9.74984 12.4984 10.4351 12.2145C11.1203 11.9307 11.706 11.4501 12.118 10.8334C12.5301 10.2167 12.75 9.49168 12.75 8.75C12.75 7.75544 12.3549 6.80161 11.6517 6.09835C10.9484 5.39509 9.99456 5 9 5ZM9 11C8.55499 11 8.11998 10.868 7.74997 10.6208C7.37996 10.3736 7.09157 10.0222 6.92127 9.61104C6.75097 9.1999 6.70642 8.7475 6.79323 8.31105C6.88005 7.87459 7.09434 7.47368 7.40901 7.15901C7.72368 6.84434 8.12459 6.63005 8.56105 6.54323C8.9975 6.45642 9.4499 6.50097 9.86104 6.67127C10.2722 6.84157 10.6236 7.12996 10.8708 7.49997C11.118 7.86998 11.25 8.30499 11.25 8.75C11.25 9.34674 11.0129 9.91903 10.591 10.341C10.169 10.7629 9.59674 11 9 11ZM9 0.5C6.81273 0.502481 4.71575 1.37247 3.16911 2.91911C1.62247 4.46575 0.752481 6.56273 0.75 8.75C0.75 11.6938 2.11031 14.8138 4.6875 17.7734C5.84552 19.1108 7.14886 20.3151 8.57344 21.3641C8.69954 21.4524 8.84978 21.4998 9.00375 21.4998C9.15772 21.4998 9.30796 21.4524 9.43406 21.3641C10.856 20.3147 12.1568 19.1104 13.3125 17.7734C15.8859 14.8138 17.25 11.6938 17.25 8.75C17.2475 6.56273 16.3775 4.46575 14.8309 2.91911C13.2843 1.37247 11.1873 0.502481 9 0.5ZM9 19.8125C7.45031 18.5938 2.25 14.1172 2.25 8.75C2.25 6.95979 2.96116 5.2429 4.22703 3.97703C5.4929 2.71116 7.20979 2 9 2C10.7902 2 12.5071 2.71116 13.773 3.97703C15.0388 5.2429 15.75 6.95979 15.75 8.75C15.75 14.1153 10.5497 18.5938 9 19.8125Z" fill="black"/>
                                </svg>
                        </span>
                        <span class="info-content">
                            Địa chỉ: 680 Sư Vạn Hạnh, Phường 12, Quận 10
                        </span>
                    </p>
                    <p class="mt-2">Inbox page:</p>
                    <p class="d-flex mt-2">
                        <span class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0.25C8.07164 0.25 6.18657 0.821828 4.58319 1.89317C2.97982 2.96451 1.73013 4.48726 0.992179 6.26884C0.254225 8.05042 0.061142 10.0108 0.437348 11.9021C0.813554 13.7934 1.74215 15.5307 3.10571 16.8943C4.46928 18.2579 6.20656 19.1865 8.09787 19.5627C9.98919 19.9389 11.9496 19.7458 13.7312 19.0078C15.5127 18.2699 17.0355 17.0202 18.1068 15.4168C19.1782 13.8134 19.75 11.9284 19.75 10C19.7473 7.41498 18.7192 4.93661 16.8913 3.10872C15.0634 1.28084 12.585 0.25273 10 0.25ZM10.75 18.2153V12.25H13C13.1989 12.25 13.3897 12.171 13.5303 12.0303C13.671 11.8897 13.75 11.6989 13.75 11.5C13.75 11.3011 13.671 11.1103 13.5303 10.9697C13.3897 10.829 13.1989 10.75 13 10.75H10.75V8.5C10.75 8.10218 10.908 7.72064 11.1893 7.43934C11.4706 7.15804 11.8522 7 12.25 7H13.75C13.9489 7 14.1397 6.92098 14.2803 6.78033C14.421 6.63968 14.5 6.44891 14.5 6.25C14.5 6.05109 14.421 5.86032 14.2803 5.71967C14.1397 5.57902 13.9489 5.5 13.75 5.5H12.25C11.4544 5.5 10.6913 5.81607 10.1287 6.37868C9.56608 6.94129 9.25 7.70435 9.25 8.5V10.75H7C6.80109 10.75 6.61033 10.829 6.46967 10.9697C6.32902 11.1103 6.25 11.3011 6.25 11.5C6.25 11.6989 6.32902 11.8897 6.46967 12.0303C6.61033 12.171 6.80109 12.25 7 12.25H9.25V18.2153C7.13575 18.0223 5.17728 17.0217 3.78198 15.4215C2.38667 13.8214 1.66195 11.7449 1.75855 9.62409C1.85515 7.50324 2.76564 5.50127 4.30064 4.0346C5.83563 2.56793 7.87696 1.74947 10 1.74947C12.1231 1.74947 14.1644 2.56793 15.6994 4.0346C17.2344 5.50127 18.1449 7.50324 18.2415 9.62409C18.3381 11.7449 17.6133 13.8214 16.218 15.4215C14.8227 17.0217 12.8643 18.0223 10.75 18.2153Z" fill="black"/>
                                </svg>
                        </span>
                        <span class="info-content">
                            <a href="https://www.facebook.com/The.C.I.U.2016">
                                Facebook/THECIU
                            </a>
                            <br>
                            <a href="https://www.facebook.com/theciusaigon">Facebook/THECIUSAIGON</a>
                        </span>
                    </p>
                    <p class="d-flex">
                        <span class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 5.5C9.10998 5.5 8.23995 5.76392 7.49993 6.25839C6.75991 6.75285 6.18314 7.45566 5.84254 8.27792C5.50195 9.10019 5.41283 10.005 5.58647 10.8779C5.7601 11.7508 6.18868 12.5526 6.81802 13.182C7.44736 13.8113 8.24918 14.2399 9.12209 14.4135C9.99501 14.5872 10.8998 14.4981 11.7221 14.1575C12.5443 13.8169 13.2471 13.2401 13.7416 12.5001C14.2361 11.76 14.5 10.89 14.5 10C14.4988 8.80691 14.0243 7.66303 13.1806 6.81939C12.337 5.97575 11.1931 5.50124 10 5.5ZM10 13C9.40666 13 8.82664 12.8241 8.33329 12.4944C7.83994 12.1648 7.45542 11.6962 7.22836 11.1481C7.0013 10.5999 6.94189 9.99667 7.05764 9.41473C7.1734 8.83279 7.45912 8.29824 7.87868 7.87868C8.29824 7.45912 8.83279 7.1734 9.41473 7.05764C9.99667 6.94189 10.5999 7.0013 11.1481 7.22836C11.6962 7.45542 12.1648 7.83994 12.4944 8.33329C12.8241 8.82664 13 9.40666 13 10C13 10.7956 12.6839 11.5587 12.1213 12.1213C11.5587 12.6839 10.7956 13 10 13ZM14.5 0.25H5.5C4.10807 0.251489 2.77358 0.805091 1.78933 1.78933C0.805091 2.77358 0.251489 4.10807 0.25 5.5V14.5C0.251489 15.8919 0.805091 17.2264 1.78933 18.2107C2.77358 19.1949 4.10807 19.7485 5.5 19.75H14.5C15.8919 19.7485 17.2264 19.1949 18.2107 18.2107C19.1949 17.2264 19.7485 15.8919 19.75 14.5V5.5C19.7485 4.10807 19.1949 2.77358 18.2107 1.78933C17.2264 0.805091 15.8919 0.251489 14.5 0.25ZM18.25 14.5C18.25 15.4946 17.8549 16.4484 17.1516 17.1516C16.4484 17.8549 15.4946 18.25 14.5 18.25H5.5C4.50544 18.25 3.55161 17.8549 2.84835 17.1516C2.14509 16.4484 1.75 15.4946 1.75 14.5V5.5C1.75 4.50544 2.14509 3.55161 2.84835 2.84835C3.55161 2.14509 4.50544 1.75 5.5 1.75H14.5C15.4946 1.75 16.4484 2.14509 17.1516 2.84835C17.8549 3.55161 18.25 4.50544 18.25 5.5V14.5ZM16 5.125C16 5.3475 15.934 5.56501 15.8104 5.75002C15.6868 5.93502 15.5111 6.07922 15.3055 6.16436C15.1 6.24951 14.8738 6.27179 14.6555 6.22838C14.4373 6.18498 14.2368 6.07783 14.0795 5.9205C13.9222 5.76316 13.815 5.56271 13.7716 5.34448C13.7282 5.12625 13.7505 4.90005 13.8356 4.69448C13.9208 4.48891 14.065 4.31321 14.25 4.1896C14.435 4.06598 14.6525 4 14.875 4C15.1734 4 15.4595 4.11853 15.6705 4.3295C15.8815 4.54048 16 4.82663 16 5.125Z" fill="black"/>
                                </svg>

                        </span>
                        <span class="info-content">
                            Instagram: <a href="https://www.instagram.com/theciusaigon/?hl=en">@theciu2016</a>
                        </span>
                    </p>
                </div>
            </section>
            <section class="shipping-section">
                <h5 class="section-title">2. HƯỚNG DẪN ĐẶT HÀNG TRÊN WEBSITE</h5>
                <div class="section-content">
                    <p>Để thuận tiện hơn trong việc mua sắm các sản phẩm trên website, quý khách hàng vui lòng tham khảo chi tiết các bước đặt hàng như sau:</p>
                    <h6 class="step-title">Bước 1: Tìm kiếm sản phẩm</h6>
                    <p>
                        <strong>Cách 1:</strong> Nhập tìm tên sản phẩm ở mục tìm kiểm tên sản phẩm
                    </p>
                    <p>
                        <strong>Cách 2:</strong> sản phẩm theo danh mục
                    </p>
                    <h6 class="step-title">Bước 2: CHỌN sản phẩm</h6>
                    <p>
                        <ul>
                            <li>Khi chọn được mẫu phù hợp, quý khách vui lòng nhấn vào hình để xem thêm phần chi tiết và mô tả sản phẩm</li>
                            <li>
                                Chọn phân loại và số lượng thích hợp
                            </li>
                            <li>Bấm vào nút: <strong>THÊM VÀO GIỎ HÀNG</strong></li>
                        </ul>
                    </p>
                    <h6 class="step-title">
                        Bước 3: CHỌN sản phẩm
                    </h6>
                    <ul>
                        <li>Chọn sản phẩm cần thanh toán</li>
                        <li>Thêm thông tin địa chỉ nhận hàng</li>
                        <li>Chọn hình thức thanh toán</li>
                        <li>Nhấn chọn <strong>THANH TOÁN</strong></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
@endsection
