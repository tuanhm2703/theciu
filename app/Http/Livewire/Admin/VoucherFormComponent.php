<?php

namespace App\Http\Livewire\Admin;

use App\Models\Voucher;
use App\Models\VoucherType;
use Livewire\Component;

class VoucherFormComponent extends Component
{
    public $voucher;

    public $voucher_types;

    public function mount() {
        $this->voucher_types = VoucherType::active()->get();
        $this->voucher = $this->voucher ?: new Voucher();
    }

    public function render()
    {
        return view('livewire.admin.voucher-form-component');
    }
}
