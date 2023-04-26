<div>
    <div class="voucher-info">
        <div class="voucher-tag">
            <div class="text-center">
                @if ($voucher->voucher_type->code == App\Models\VoucherType::ORDER)
                    @component('components.client.icons.order-voucher-icon')
                    @endcomponent
                @else
                    @component('components.client.icons.shipping-voucher-icon')
                    @endcomponent
                @endif
            </div>
            <h6 class="font-weight-bold my-3">Chúc mừng bạn!</h6>
            <h5 class="text-center voucher-discount-info mb-0">{{ $voucher->discount_label }}</h5>
        </div>
    </div>
    <div class="congrats-content pt-0">
        <p class="text-center mb-1 text-center text-dark">Đơn tối thiểu từ
            {{ format_currency_with_label($voucher->min_order_value) }}</p>
        <div class="text-center">
            <button @disabled($voucher->saved || $voucher->quantity == 0) wire:click="saveVoucher({{ $voucher->id }})"
                class="btn btn-primary font-weight-bold text-uppercase">
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
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {})
    </script>
@endpush
