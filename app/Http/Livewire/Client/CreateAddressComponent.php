<?php

namespace App\Http\Livewire\Client;

use App\Enums\AddressType;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Livewire\Component;

class CreateAddressComponent extends Component {
    public $address;

    public $provinces;

    public $districts = [];

    public $wards = [];

    public $address_type = AddressType::SHIPPING;

    public function mount() {
        $this->address = new Address();
        $this->address->type = AddressType::SHIPPING;
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

    protected $rules = [
        'address.fullname' => 'required',
        'address.details' => 'required',
        'address.phone' => 'required|phone_number',
        'address.featured' => 'nullable',
        'address.province_id' => 'required',
        'address.district_id' => 'required',
        'address.ward_id' => 'required',
        'address.type' => 'string'
    ];

    protected $validationAttributes = [
        'address.details' => 'địa chỉ chi tiết',
        'address.fullname' => 'họ tên',
        'address.phone' => 'số điện thoại',
        'address.province_id' => 'thành phố',
        'address.district_id' => 'quận/huyện',
        'address.ward_id' => 'phường/xã',
    ];

    public function render() {
        return view('livewire.client.create-address-component');
    }

    public function store() {
        $this->validate();
        $this->address->featured = $this->address->featured ? 1 : 0;
        auth('customer')->user()->addresses()->create($this->address->toArray());
        $this->dispatchBrowserEvent('addressUpdated', [
            'message' => 'Tạo địa chỉ thành công'
        ]);
    }


}
