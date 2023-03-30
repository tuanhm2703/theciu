<?php

namespace App\Http\Livewire\Client;

use App\Models\Voucher;
use Livewire\Component;

class ListSavedVoucherComponent extends Component
{
    public $vouchers;
    public $show = false;
    protected $listeners = ['showVoucherPool', 'showVoucherPool'];

    public function mount()
    {
        $this->vouchers = Voucher::available()->saveable()->get();
        if(customer()) {
            $saved_voucher_ids = customer()->saved_vouchers()->haveNotUsed()->pluck('id')->toArray();
            $this->vouchers->each(function($voucher) use ($saved_voucher_ids) {
                $voucher->saved = in_array($voucher->id, $saved_voucher_ids);
            });
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
