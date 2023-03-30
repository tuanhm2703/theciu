<?php

namespace App\Http\Livewire\Client;

use App\Models\Voucher;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VoucherPopupComponent extends Component
{
    public $vouchers;
    public function mount() {
        $this->vouchers = Voucher::featured()->available()->get();
    }
    public function render()
    {
        return view('livewire.client.voucher-popup-component');
    }

    public function setSessionNoReopen() {
        Session::put('prevent-reopen-voucher-popup', true);
    }

    public function saveVoucher() {
        $this->dispatchBrowserEvent('openLoginForm');
    }


}
