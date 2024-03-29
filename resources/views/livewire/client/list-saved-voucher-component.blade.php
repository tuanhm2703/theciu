<div id="save-voucher-component-wrapper" class="hide" wire:init="loadVouchers">
    @if ($readyToLoad)
        <i class="fa fa-angle-double-down w-100 text-center" id="close-voucher-list-btn"></i>
        @if ($vouchers->count() == 0)
            <div class="text-center">
                <i>{{ trans('labels.no_voucher_available') }}</i>
            </div>
        @endif
        @foreach ($voucher_types as $type)
            @if ($vouchers->where('voucher_type_id', $type->id)->count() > 0)
                @foreach ($vouchers->where('voucher_type_id', $type->id) as $voucher)
                    <livewire:client.save-voucher-component :voucher="$voucher"
                        wire:key="save-voucher-item-{{ $voucher->id }}" />
                @endforeach
            @endif
        @endforeach
    @endif
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @this.updateVoucherStatus();
        })
    </script>
@endpush
