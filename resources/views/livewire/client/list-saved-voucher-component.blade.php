<div id="save-voucher-component-wrapper" class="{{ $show ? '' : 'hide' }}" wire:init="loadVouchers">
    @if ($readyToLoad)
        <i class="fa fa-angle-double-down" id="close-voucher-list-btn" wire:click="$set('show', {{ !$show }})"></i>
        @if ($vouchers->count() == 0)
            <div class="text-center">
                <i>{{ trans('labels.no_voucher_available') }}</i>
            </div>
        @endif
        @foreach ($vouchers as $voucher)
            <livewire:client.save-voucher-component :voucher="$voucher" wire:key="save-voucher-item-{{ $voucher->id }}" />
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
