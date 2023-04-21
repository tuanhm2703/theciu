<?php

namespace App\Http\Livewire\Client;

use App\Models\Voucher;
use App\Traits\Common\LazyloadLivewire;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VoucherPopupComponent extends Component
{
    use LazyloadLivewire;
    public $vouchers;

    protected $rules = [
        'vouchers' => 'nullable'
    ];

    public function mount() {
        $this->vouchers = new Collection();
    }

    public function loadVouchers() {
        if(customer()) {
            $this->vouchers = Voucher::notExpired()->where('quantity', '>', 0)->saveable()->get();
            $saved_vouchers = customer()->saved_vouchers()->get();
            $this->vouchers->each(function($voucher) use ($saved_vouchers) {
                $voucher->saved = in_array($voucher->id, $saved_vouchers->pluck('id')->toArray());
                $voucher->used = $saved_vouchers->where('id', $voucher->id)->where('pivot.is_used', 1)->first() ? true : false;
            });
            $this->vouchers = $this->vouchers->filter(function($value, $key) {
                return $value->used == false;
            });
        } else {
            $this->vouchers = Voucher::notExpired()->where('quantity', '>', 0)->featured()->saveable()->get();
        }
        $this->readyToLoad = true;
        if(!Session::has('prevent-reopen-voucher-popup') && $this->vouchers->where('saved', false)->where('quantuty', '>', 0)->count() > 0) {
            $this->emit('initPlugin', $this->vouchers);
        }
    }
    public function render()
    {
        return view('livewire.client.voucher-popup-component');
    }

    public function setSessionNoReopen() {
        Session::put('prevent-reopen-voucher-popup', true);
    }

    public function saveVoucher($id) {
        if(!auth('customer')->check()) {
            $this->dispatchBrowserEvent('openLoginForm');
        } else {
            $voucher = $this->vouchers->where('id', $id)->first();
            if(Voucher::available()->where('quantity', '>', 0)->where('id', $id)->exists()) {
                customer()->saved_vouchers()->sync([
                    $voucher->id, [
                        'is_used' => false,
                        'type' => $voucher->voucher_type_id
                    ]
                ], false);
                $voucher->update([
                    'quantity' => DB::raw('quantity - 1')
                ]);
                $voucher->saved = true;
                $this->emit('cart:reloadVoucher');
                $this->loadVouchers();
            } else {
                $voucher->quantity = 0;
            }
        }
    }


}
