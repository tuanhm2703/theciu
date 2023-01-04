<div class="form-check form-switch justify-content-center">
    <input class="form-check-input voucher-status" data-voucher-id="{{ $voucher->id }}" type="checkbox"
        id="voucher-status-{{ $voucher->id }}" @if ($voucher->status) checked @endif>
</div>
