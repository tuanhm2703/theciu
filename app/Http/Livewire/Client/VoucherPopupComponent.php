<?php

namespace App\Http\Livewire\Client;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VoucherPopupComponent extends Component
{
    public function mount() {
        Session::put('hideVoucherPopup', 'hello');
    }
    public function render()
    {
        return view('livewire.client.voucher-popup-component');
    }

    public function saveVoucher() {
        $this->dispatchBrowserEvent('openLoginForm');
    }


}
