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
        $addresses = auth('customer')->user()->addresses()->with('ward.district.province')->orderBy('type')->get();
        return view('landingpage.layouts.pages.profile.address.change', compact('addresses'));
    }

    public function viewCreate(Request $request) {
        $provinces = Province::pluck('name', 'id')->toArray();
        return view('landingpage.layouts.pages.profile.address.create', compact('provinces'));
    }

    public function store(CreateAddressRequest $request) {
        $ward = Ward::with('district.province')->find($request->input('ward_id'));
        $request->merge([
            'district_id' => $ward->district->id,
            'province_id' => $ward->district->province->id
        ]);
        Address::create($request->all());
        return BaseResponse::success([
            'message' => 'Thêm địa chỉ thành công'
        ]);
    }
}
