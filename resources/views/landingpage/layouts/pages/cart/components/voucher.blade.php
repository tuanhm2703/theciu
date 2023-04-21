<div wire:ignore.self class="modal fade" id="voucherListModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalSignTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5">
                    <h5 class="row text-bold">Chọn Voucher</h5>
                    <div class="row bg-light p-3">
                        <div class="col-3 d-flex align-items-center">
                            <label class="m-0" for="">Mã voucher</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <input type="text" wire:model="voucher_code" wire:lazy placeholder="Mã voucher" class="form-control m-0">
                        </div>
                        <div class="col-3 d-flex align-items-center">
                            <button style="min-width: fit-content" class="btn btn-primary" wire:click.prevent="applyVoucher">ÁP DỤNG</button>
                        </div>
                    </div>
                    <div class="my-3 row mt-5">
                        <div class="col-12 p-0">
                            <h6 class="mb-0">Mã giảm giá đơn hàng</h6>
                            <p><span>Có thể chọn 1 Voucher</span></p>
                        </div>
                    </div>
                    @foreach ($vouchers as $voucher)
                        <div class="custom-control custom-radio voucher-radio row">
                            <input type="radio" wire:model="{{ $voucher->voucher_type->code == App\Models\VoucherType::ORDER ? 'order_voucher_id' : 'freeship_voucher_id' }}" value="{{ $voucher->id }}"
                                id="voucher-{{ $voucher->id }}" class="custom-control-input"
                                @disabled($voucher->disabled)>
                            <label for="voucher-{{ $voucher->id }}"
                                class="custom-control-label {{ $voucher->disabled ? 'voucher-label-disabled' : '' }}">
                                <div class="voucher-type-label order-voucher-label">
                                    <span class="text-bold text-uppercase text-center">
                                        <img class="p-2" src="{{ asset('img/logo-white.png') }}" alt="">
                                        {{ $voucher->voucher_type->name }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="text-bold voucher-name mb-0">{{ $voucher->name }}</h6>
                                    <div><span>Đơn tối thiểu {{ format_currency_with_label($voucher->min_order_value) }}</span></div>
                                    <div class="voucher-description">
                                        Giảm giá {{ $voucher->getDiscountLabelAttribute() }} -
                                        {{ $voucher->max_discount_amount ? trans('labels.max') . ' ' . format_currency_with_label($voucher->max_discount_amount) : trans('labels.unlimit') }}
                                    </div>
                                </div>
                            </label>
                        </div><!-- End .custom-control -->
                    @endforeach
                    <div class="row mt-3" style="justify-content: right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('labels.accept') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
