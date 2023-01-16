<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProfileAddressInfo extends Component {
    public $address;

    public $shipping_addresses;

    public function mount() {
        $this->address = auth('customer')->user()->primary_address;
        $this->shipping_addresses = auth('customer')->user()->shipping_addresses;
    }
    public function render() {
        return view('livewire.profile-address-info');
    }
}
