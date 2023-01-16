<?php

namespace App\Http\Livewire\Admin\Address;

use App\Models\Address;
use App\Models\Config;
use Livewire\Component;

class Index extends Component {
    public $addresses;

    protected $listeners = ['admin:address:refresh' => 'reRender'];

    public function mount() {
        $this->addresses = Config::select('id')->first()->pickup_addresses()->get();
    }

    public function render() {
        return view('livewire.admin.address.index');
    }

    public function delete(Address $address) {
        $address->delete();
        $this->addresses = Config::select('id')->first()->pickup_addresses()->get();
    }

    public function reRender() {
        $this->addresses = Config::select('id')->first()->pickup_addresses()->get();
    }
}
