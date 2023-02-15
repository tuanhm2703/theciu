<?php

namespace App\Http\Livewire;

use App\Enums\AddressType;
use App\Models\Address;
use Livewire\Component;

class UpdateAddressComponent extends Component {
    public $address;

    public $address_type = AddressType::SHIPPING;

    protected $listeners = ['address:change' => 'changeAddress'];

    public function render() {
        return view('livewire.update-address-component');
    }

    public function changeAddress(Address $address) {
        $this->address = $address;
        $this->address_type = $address->type;
    }
}
