<?php

namespace App\Http\Livewire\Client;

use App\Models\Voucher;
use App\Traits\Common\LazyloadLivewire;
use Livewire\Component;

class ListSavedVoucherComponent extends Component
{
    use LazyloadLivewire;
    public $vouchers;
    public $show = false;
    protected $listeners = ['showVoucherPool', 'showVoucherPool', 'loadVouchers'];
    public $numberOfAvailableVoucher = 0;

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
            $this->numberOfAvailableVoucher = $this->vouchers->where('saved', 0)->count();
        } else {
            $this->vouchers = Voucher::available()->saveable()->get();
            $this->numberOfAvailableVoucher = $this->vouchers->count();
        }
        $this->emit('updateVoucherStatus', $this->numberOfAvailableVoucher);
        $this->readyToLoad = true;

    }
    public function updateVoucherStatus() {
        $this->emit('updateVoucherStatus', $this->numberOfAvailableVoucher);
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
