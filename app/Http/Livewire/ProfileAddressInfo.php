<?php

namespace App\Http\Livewire;

use App\Enums\AddressType;
use App\Models\Address;
use Livewire\Component;

class ProfileAddressInfo extends Component {
    public $address;

    public $shipping_addresses;

    public $address_type = AddressType::PRIMARY;

    protected $listeners = ['refresh' => 'reloadAddress'];

    public function mount() {
        $this->address = auth('customer')->user()->primary_address;
        $this->shipping_addresses = auth('customer')->user()->shipping_addresses;
    }
    public function render() {
        return view('livewire.profile-address-info');
    }

    public function updateAddressType($type) {
        $this->address_type = $type;
    }

    public function openUpdateAddress(Address $address) {
        $this->emit('address:change', $address->id);
        $this->address_type = $address->type;
    }

    public function reloadAddress() {
        $this->address = auth('customer')->user()->primary_address;
        $this->shipping_addresses = auth('customer')->user()->shipping_addresses;
    }
}
