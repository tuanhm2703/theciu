<?php

namespace App\Http\Livewire\Admin\Address;

use App\Models\Address;
use Livewire\Component;

class Update extends Component {
    protected $listeners = ['address:edit' => 'edit'];
    public $address;
    public function render() {
        return view('livewire.admin.address.update');
    }

    public function edit(Address $address) {
        $this->address = $address;
    }
}
