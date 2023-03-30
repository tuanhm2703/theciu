<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class StickyVoucherIconComponent extends Component
{
    protected $listeners = ['updateVoucherStatus', 'updateVoucherStatus'];
    public $numberOfVouchers = 0;
    public function render()
    {
        return view('livewire.client.sticky-voucher-icon-component');
    }

    public function updateVoucherStatus($numberOfVouchers) {
        $this->numberOfVouchers = $numberOfVouchers;
    }
}
