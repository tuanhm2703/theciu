<?php

namespace App\Http\Livewire\Client;

use App\Models\Voucher;
use Livewire\Component;

class ListSavedVoucherComponent extends Component
{
    public $vouchers;
    public $show = false;
    protected $listeners = ['showVoucherPool', 'showVoucherPool', 'loadVouchers'];

    public function mount()
    {
        $this->loadVouchers();
    }
    public function loadVouchers() {
        if(customer()) {
            $this->vouchers = Voucher::available()->saveable()->get();
            $saved_vouchers = customer()->saved_vouchers()->get();
            $this->vouchers->each(function($voucher) use ($saved_vouchers) {
                $voucher->saved = in_array($voucher->id, $saved_vouchers->pluck('id')->toArray());
                $voucher->used = $saved_vouchers->where('id', $voucher->id)->where('pivot.is_used', 1)->first() ? true : false;
                if($voucher->used) $this->vouchers->forget("");
            });
            $this->vouchers = $this->vouchers->filter(function($value, $key) {
                return $value->used == false;
            });
        } else {
            $this->vouchers = Voucher::available()->saveable()->get();
        }
    }
    public function updateVoucherStatus() {
        $this->emit('updateVoucherStatus', $this->vouchers->where('quantity', '>', 0)->where('saved', 0)->count());
    }
    public function render()
    {
        return view('livewire.client.list-saved-voucher-component');
    }
    public function showVoucherPool()
    {
        $this->show = !$this->show;
    }
}
