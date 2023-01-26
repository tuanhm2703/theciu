<?php

namespace App\Http\Livewire;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Livewire\Component;

class AddressSelectComponent extends Component {
    public $province_id;
    public $provinces;

    public $district_id;
    public $districts = [];

    public $ward_id;
    public $wards = [];

    public $address;

    public function mount() {
        $this->provinces = Province::select('name', 'id')->orderBy('name', 'desc')->get();
        $this->province_id = $this->address ? $this->address->province_id : $this->provinces->first()->id;
        $this->districts = District::where('parent_id', $this->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        $this->district_id = $this->address ? $this->address->district_id : $this->districts->first()->id;
        $this->wards = Ward::where('parent_id', $this->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        $this->ward_id = $this->address ? $this->address->ward_id : $this->wards->first()->id;
    }

    public function changeProvince() {
        $this->districts = District::where('parent_id', $this->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        $this->district_id = $this->districts->first()->id;
        $this->changeDistrict();
    }

    public function changeDistrict() {
        $this->wards = Ward::where('parent_id', $this->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
    }

    public function render() {
        return view('livewire.address-select-component');
    }
    public function rules() {
        return [
            'province_id' => 'required',
            'ward_id' => 'required',
            'district_id' => 'required'
        ];
    }
}
