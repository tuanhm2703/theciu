<?php

namespace App\Http\Livewire;

use App\Models\Address;
use Livewire\Component;

class UpdateAddressComponent extends Component {
    public $address;

    protected $listeners = ['address:change' => 'changeAddress'];

    public function render() {
        return view('livewire.update-address-component');
    }

    public function changeAddress(Address $address) {
        $this->address = $address;
    }
}
