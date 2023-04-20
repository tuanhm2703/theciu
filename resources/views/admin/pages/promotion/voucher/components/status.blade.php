<div class="form-check form-switch justify-content-center">
    <input class="form-check-input voucher-status" data-voucher-id="{{ $voucher->id }}" type="checkbox"
    data-submit-url="{{ route('admin.ajax.promotion.voucher.update.status', $voucher->id) }}"
        id="voucher-status-{{ $voucher->id }}" @if ($voucher->status) checked @endif>
</div>
