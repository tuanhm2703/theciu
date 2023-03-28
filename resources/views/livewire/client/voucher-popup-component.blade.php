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
        <div>
            <div class="voucher-info">
                <div class="voucher-tag">
                    <p class="text-center mb-1 text-center">Đơn tối thiểu từ 43k</p>
                    <h5 class="text-center text-danger">Giảm 30k</h5>
                    <div class="text-center py-2">
                        <strong>Mã: TCT323</strong>
                    </div>
                    <div id="voucher-circle-left"></div>
                    <div id="voucher-circle-right"></div>
                </div>
            </div>
            <div class="congrats-content">
                <h5 class="text-danger text-center mb-0">Chúc mừng bạn</h5>
                <p class="text-center mb-0">Lưu voucher ngay để sử dụng</p>
                <small class="d-block text-center my-2 mt-1">Hiệu lực đến 04-08-2023</small>
                <div class="text-center">
                    <button wire:click="saveVoucher"
                        class="btn btn-danger">{{ auth('customer')->check() ? trans('labels.save_now') : trans('labels.login_now') }}</button>
                </div>
            </div>
        </div>
        <div>
            <div class="voucher-info">
                <div class="voucher-tag">
                    <p class="text-center mb-1 text-center">Đơn tối thiểu từ 43k</p>
                    <h5 class="text-center text-danger">Giảm đ30k</h5>
                    <div class="text-center py-2">
                        <strong>Mã: TCT323</strong>
                        <strong>{{ Session::get('hideVoucherPopup') }}</strong>
                    </div>
                    <div id="voucher-circle-left"></div>
                    <div id="voucher-circle-right"></div>
                </div>
            </div>
            <div class="congrats-content">
                <h5 class="text-danger text-center mb-0">Chúc mừng bạn</h5>
                <p class="text-center mb-0">Lưu voucher ngay để sửa dụng</p>
                <small class="d-block text-center my-2 mt-3">Hiệu lực đến 04-08-2023</small>
                <div class="text-center">
                    <button wire:click="saveVoucher"
                        class="btn btn-danger">{{ auth('customer')->check() ? trans('labels.save_now') : trans('labels.login_now') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
