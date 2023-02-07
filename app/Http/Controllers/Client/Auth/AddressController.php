<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateAddressRequest;
use App\Models\Address;
use App\Models\Province;
use App\Models\Ward;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class AddressController extends Controller {
    public function viewChangeAddress(Request $request) {
        $selected_address_id = $request->selected_address_id;
        $addresses = auth('customer')->user()->shipping_addresses()->with('ward.district.province')->orderBy('type')->get();
        return view('landingpage.layouts.pages.profile.address.change', compact('addresses', 'selected_address_id'));
    }

    public function viewCreate(Request $request) {
        $provinces = Province::pluck('name', 'id')->toArray();
        return view('landingpage.layouts.pages.profile.address.create', compact('provinces'));
    }

    public function store(Request $request) {
        $ward = Ward::with('district.province')->find($request->input('ward_id'));
        $request->merge([
            'district_id' => $ward->district->id,
            'province_id' => $ward->district->province->id,
            'featured' => $request->input('featured') == 'on' ? 1 : '0'
        ]);
        $customer = auth('customer')->user();
        if($request->input('featured') == 1) {
            $customer->shipping_addresses()->update(['featured' => 0]);
        }
        $customer->addresses()->create($request->all());
        return BaseResponse::success([
            'message' => 'Thêm địa chỉ thành công'
        ]);
    }

    public function update(Address $address, Request $request) {
        $ward = Ward::with('district.province')->find($request->input('ward_id'));
        $request->merge([
            'district_id' => $ward->district->id,
            'province_id' => $ward->district->province->id,
            'featured' => $request->input('featured') == 'on' ? 1 : '0'
        ]);
        $customer = auth('customer')->user();
        if($request->input('featured') == 1) {
            $customer->shipping_addresses()->where('addresses.id', '!=', $address->id)->update(['featured' => 0]);
        }
        $address->update($request->all());
        return BaseResponse::success([
            'message' => 'Cập nhật địa chỉ thành công'
        ]);
    }

    public function index() {
        return view('landingpage.layouts.pages.profile.address');
    }
}
