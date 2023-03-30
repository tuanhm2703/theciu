<div class="voucher-popup container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
    <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
        data-owl-options='{
        "dots": true,
        "nav": true,
        "margin": 30,
        "autoplay": true,
        "autoplayTimeout": 3000,
        "items": 1,
        }'>
        @foreach ($vouchers as $voucher)
            <div>
                <div class="voucher-info">
                    <div class="voucher-tag">
                        <p class="text-center mb-1 text-center">Đơn tối thiểu từ
                            {{ thousandsCurrencyFormat($voucher->min_order_value) }}</p>
                        <h5 class="text-center text-danger">Giảm {{ $voucher->discount_label }}</h5>
                        <div class="text-center py-2">
                            <strong>Mã: {{ $voucher->code }}</strong>
                        </div>
                        <div class="voucher-circle-left"></div>
                        <div class="voucher-circle-right"></div>
                    </div>
                </div>
                <div class="congrats-content">
                    <h5 class="text-danger text-center mb-0">Chúc mừng bạn</h5>
                    <p class="text-center mb-0">Lưu voucher ngay để sử dụng</p>
                    <small class="d-block text-center my-2 mt-1">Hiệu lực đến
                        {{ $voucher->end->format('d-m-Y H:i') }}</small>
                    <div class="text-center">
                        <button wire:click="saveVoucher"
                            class="btn btn-danger">{{ auth('customer')->check() ? trans('labels.save_now') : trans('labels.login_now') }}</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="text-center text-white mt-1">
        <span wire:click="" id="close-no-reopen"><i class="fa fa-times"></i> Không hiện lại</span>
    </div>
</div>
<script>
    if (@json(Session::get('prevent-reopen-voucher-popup') !== true)) {
        setTimeout(function() {
            $.magnificPopup.open({
                items: {
                    src: "#newsletter-popup-form",
                },
                type: "inline",
                removalDelay: 350,
                callbacks: {
                    open: function() {
                        $("body").css("overflow-x", "visible");
                        $(".sticky-header.fixed").css(
                            "padding-right",
                            "1.7rem"
                        );
                    },
                    close: function() {
                        $("body").css("overflow-x", "hidden");
                        $(".sticky-header.fixed").css("padding-right", "0");
                    },
                },
            });
        }, 2000);
    }
    $('#close-no-reopen').on('click', (e) => {
        var mpInstance = $.magnificPopup.instance;
        if (mpInstance.isOpen) {
            mpInstance.close();
        }
        @this.setSessionNoReopen()
    })
</script>
