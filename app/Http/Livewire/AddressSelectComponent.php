<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Livewire\Component;

class AddressSelectComponent extends Component {
    public $provinces;

    public $districts = [];

    public $wards = [];

    public $address;

    protected $rules = [
        'address.province_id' => 'required',
        'address.district_id' => 'required',
        'address.ward_id' => 'required'
    ];

    public function mount() {
        $this->address = $this->address ? $this->address : new Address();
        $this->provinces = Province::select('name', 'id')->orderBy('name', 'desc')->get();
        $this->address->province_id = $this->address->province_id ? $this->address->province_id : $this->provinces->first()->id;
        $this->districts = District::where('parent_id', $this->address->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        $this->address->district_id = $this->address->district_id ? $this->address->district_id : $this->districts->first()->id;
        $this->wards = Ward::where('parent_id', $this->address->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        $this->address->ward_id = $this->address->ward_id ? $this->address->ward_id : $this->wards->first()->id;
    }

    public function changeProvince() {
        $this->districts = District::where('parent_id', $this->address->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        $this->address->district_id = $this->districts->first()->id;
        $this->changeDistrict();
    }

    public function changeDistrict() {
        $this->wards = Ward::where('parent_id', $this->address->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
    }

    public function render() {
        return view('livewire.address-select-component');
    }
}
