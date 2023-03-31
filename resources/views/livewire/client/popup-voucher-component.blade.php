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
            <button @disabled($voucher->saved || $voucher->quantity == 0) wire:click="saveVoucher({{ $voucher->id }})"
                class="btn btn-danger">
                <span wire:loading wire:target="saveVoucher" class="spinner-border spinner-border-sm mr-3"
                    role="status" aria-hidden="true"></span>
                <span wire:loading.remove wire:target="saveVoucher">
                    @if (auth('customer')->check())
                        @if ($voucher->saved)
                            {{ trans('labels.saved') }}
                        @elseif($voucher->quantity == 0)
                            {{ trans('labels.out_of_quantity') }}
                        @else
                            {{ trans('labels.save') }}
                        @endif
                    @else
                        {{ trans('labels.login_now') }}
                    @endif
                </span>
            </button>
        </div>
    </div>
</div>
