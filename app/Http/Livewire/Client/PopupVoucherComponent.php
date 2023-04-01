<?php

namespace App\Http\Livewire\Client;

use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PopupVoucherComponent extends Component
{
    public $voucher;
    public function render()
    {
        return view('livewire.client.popup-voucher-component');
    }
    public function saveVoucher() {
        if(!auth('customer')->check()) {
            $this->dispatchBrowserEvent('openLoginForm');
        } else {
            if(Voucher::available()->where('quantity', '>', 0)->where('id', $this->voucher->id)->exists()) {
                customer()->saved_vouchers()->sync([
                    $this->voucher->id => [
                        'is_used' => false,
                        'type' => $this->voucher->voucher_type_id
                    ]
                ], false);
                $this->voucher->update([
                    'quantity' => DB::raw('quantity - 1')
                ]);
                $this->voucher->saved = true;
                $this->emit('cart:reloadVoucher');
                $this->emitTo('client.list-saved-voucher-component', 'loadVouchers');
            } else {
                $this->voucher->quantity = 0;
            }
        }
    }
}
