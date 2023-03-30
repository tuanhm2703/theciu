<article class="voucher-container">
    <div class="voucher-title">
        <span class="text-center">{{ $voucher->name }}</span>
    </div>
    <div class="voucher-splitter">
        <div class="voucher-top-circle"></div>
        <div class="voucher-bottom-circle"></div>
    </div>
    <div class="voucher-detail-info" style="background-color: rgb(255, 255, 255)">
        <div class="voucher-detail-left">
            <h1 class="voucher-discount-value mb-0">
                Giảm {{ $voucher->discount_label }}
            </h1>
            <p class="nvgK1r" style="color: rgb(89, 89, 89)">
                {{ $voucher->discount_description }}
            </p>
            <div>
                <span>{{ getAppName() }}</span>
            </div>
            <div>
                <div>
                    <span>Có hiệu lực từ {{ $voucher->begin->format('d.m.Y') }}</span>
                </div>
            </div>
        </div>
        <div class="voucher-detail-right">
            <button class="btn btn-secondary mb-1" wire:click="saveVoucher"
                @disabled($voucher->saved || $voucher->quantity == 0)>
                <span wire:loading wire:target="saveVoucher" class="spinner-border spinner-border-sm mr-3"
                    role="status" aria-hidden="true"></span>
                <span wire:loading.remove
                    wire:target="saveVoucher">
                    @if ($voucher->saved)
                        {{ trans('labels.saved') }}
                    @elseif($voucher->quantity == 0)
                        {{ trans('labels.out_of_quantity') }}
                    @else
                    {{ trans('labels.save') }}
                    @endif
                </span>
            </button>
            <a href="#">Điều Kiện</a>
        </div>
    </div>
</article>
