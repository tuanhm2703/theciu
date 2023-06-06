<?php

namespace App\Http\Livewire\Client;

use App\Enums\AddressType;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UpdateAddressComponent extends Component {
    public $address;


    public $provinces;

    public $districts = [];

    public $wards = [];

    public $address_type = AddressType::SHIPPING;

    protected $listeners = ['address:change' => 'changeAddress'];

    protected $rules = [
        'address.fullname' => 'required',
        'address.details' => 'required',
        'address.phone' => 'required|phone_number',
        'address.province_id' => 'required',
        'address.district_id' => 'required',
        'address.ward_id' => 'required',
        'address.featured' => 'nullable'
    ];

    public function mount() {
        $this->address = $this->address ? $this->address : new Address();
        $this->provinces = Cache::remember('provinces', 600, function () {
            return Province::select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->province_id = $this->address->province_id ? $this->address->province_id : $this->provinces->first()->id;
        $this->districts = Cache::remember("districts:". $this->address->province_id, 600, function() {
            return District::where('parent_id', $this->address->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->district_id = $this->address->district_id ? $this->address->district_id : $this->districts->first()->id;
        $this->wards = Cache::remember("wards:".$this->address->district_id, 600, function () {
            return Ward::where('parent_id', $this->address->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->ward_id = $this->address->ward_id ? $this->address->ward_id : $this->wards->first()->id;
    }

    public function changeProvince() {
        $this->districts = Cache::remember("districts:". $this->address->province_id, 600, function() {
            return District::where('parent_id', $this->address->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->district_id = $this->districts->first()->id;
        $this->changeDistrict();
    }

    public function changeDistrict() {
        $this->wards = Cache::remember("wards:".$this->address->district_id, 600, function () {
            return Ward::where('parent_id', $this->address->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->ward_id = $this->wards->first()->id;
    }


    protected $validationAttributes = [
        'address.details' => 'địa chỉ chi tiết',
        'address.fullname' => 'họ tên',
        'address.phone' => 'số điện thoại'
    ];

    public function render() {
        return view('livewire.client.update-address-component');
    }

    public function changeAddress(Address $address) {
        $this->address = $address;
        $this->address_type = $address->type;
        $this->provinces = Cache::remember('provinces', 600, function () {
            return Province::select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->province_id = $this->address->province_id ? $this->address->province_id : $this->provinces->first()->id;
        $this->districts = Cache::remember("districts:". $this->address->province_id, 600, function() {
            return District::where('parent_id', $this->address->province_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->district_id = $this->address->district_id ? $this->address->district_id : $this->districts->first()->id;
        $this->wards = Cache::remember("wards:".$this->address->district_id, 600, function () {
            return Ward::where('parent_id', $this->address->district_id)->select('name', 'id')->orderBy('name', 'desc')->get();
        });
        $this->address->ward_id = $this->address->ward_id ? $this->address->ward_id : $this->wards->first()->id;
    }

    public function updateAddress() {
        $this->validate();
        $this->address->featured = $this->address->featured ? 1 : 0;
        if($this->address->featured) {
            customer()->addresses()->where('addresses.id', '!=', $this->address->id)->update([
                'featured' => 0
            ]);
        }
        $this->address->save();
        $this->emitTo('profile-address-info', 'refresh');
        $this->dispatchBrowserEvent('addressUpdated', [
            'message' => 'Cập nhật địa chỉ thành công'
        ]);
    }
}
