<div id="save-voucher-component-wrapper" class="{{ $show ? '' : 'hide' }}">
    <i class="fa fa-angle-double-down" id="close-voucher-list-btn" wire:click="$set('show', {{ !$show }})"></i>
    @foreach ($vouchers as $voucher)
        <livewire:client.save-voucher-component :voucher="$voucher" wire:key="save-voucher-item-{{ $voucher->id }}" />
    @endforeach
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        @this.updateVoucherStatus();
    })
</script>
