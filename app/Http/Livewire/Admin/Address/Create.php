<?php

namespace App\Http\Livewire\Admin\Address;

use App\Enums\AddressType;
use Livewire\Component;

class Create extends Component
{
    public $address_type = AddressType::SHIPPING;
    public function render()
    {
        return view('livewire.admin.address.create');
    }
}
