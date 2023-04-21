<div class="w-100 box-shadow p-1 mb-1 voucher-info-wrapper">
    <article class="voucher-container">
        <div class="voucher-title">
            <span class="text-center">
                @if ($voucher->voucher_type->code == App\Models\VoucherType::ORDER)
                   @component('components.client.icons.order-voucher-icon')

                   @endcomponent
                @else
                   @component('components.client.icons.shipping-voucher-icon')

                   @endcomponent
                @endif
            </span>
        </div>
        <div class="voucher-splitter">
            <div class="voucher-top-circle"></div>
            <div class="voucher-bottom-circle"></div>
        </div>
        <div class="voucher-detail-info">
            <div class="voucher-detail-left">
                <h3 class="voucher-discount-value mb-1">
                    Giảm {{ $voucher->discount_label }}
                </h3>
                <p>
                    {{ $voucher->discount_description }}
                </p>
                <div>
                    <div>
                        <span>HSD: {{ $voucher->begin->format('d/m') }} - {{ $voucher->end->format('d/m') }}</span>
                    </div>
                </div>
            </div>
            <div class="voucher-detail-right">
                <button class="btn btn-primary mb-1" wire:click="saveVoucher" @disabled($voucher->saved || $voucher->quantity == 0)>
                    <span wire:loading wire:target="saveVoucher" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                    <span wire:loading.remove wire:target="saveVoucher">
                        @if ($voucher->saved)
                            {{ trans('labels.saved') }}
                        @elseif($voucher->quantity == 0)
                            {{ trans('labels.out_of_quantity') }}
                        @else
                            {{ trans('labels.save') }}
                        @endif
                    </span>
                </button>
                <a class="open-detail-voucher-btn" data-voucher-id="{{ $voucher->id }}" href="#">Điều Kiện</a>
            </div>
        </div>
    </article>
    <div class="voucher-condition-detail" data-voucher-id="{{ $voucher->id }}">
        <div class="voucher-condition-info-group mb-2">
            <span class="info-label">Tên chương trình</span>
            <span class="info-content">{{ $voucher->name }}</span>
        </div>
        <div class="voucher-condition-info-group mb-2">
            <span class="info-label">Hạn sử dụng mã</span>
            <span class="info-content">{{ $voucher->begin->format('d/m/Y H:i') }} -
                {{ $voucher->end->format('d/m/Y H:i') }}</span>
        </div>
        <div class="voucher-condition-info-group mb-2">
            <span class="info-label">Ưu đãi</span>
            <span class="info-content">{{ $voucher->getDiscountDescriptionAttribute() }}</span>
        </div>
        <div class="voucher-condition-info-group mb-2">
            <span class="info-label">Xem chi tiết</span>
            <span class="info-content">{{ $voucher->detail_info }}</span>
        </div>
        <div class="text-center"><a href="#" class="open-detail-voucher-btn"
                data-voucher-id="{{ $voucher->id }}">Đóng</a></div>
    </div>
</div>
