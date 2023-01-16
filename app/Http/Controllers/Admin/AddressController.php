<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Config;
use App\Models\Ward;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class AddressController extends Controller {
    public function index() {
        $addresses = Config::select('id')->first()->pickup_addresses()->get();
        return view('admin.pages.setting.address.index', compact('addresses'));
    }

    public function edit(Address $address) {
        return view('admin.pages.setting.address.components.edit', compact('address'));
    }

    public function update(Address $address, Request $request) {
        $ward = Ward::with('district.province')->find($request->input('ward_id'));
        $request->merge([
            'district_id' => $ward->district->id,
            'province_id' => $ward->district->province->id,
            'featured' => $request->input('featured') == 'on' ? 1 : '0'
        ]);
        $config = Config::select('id')->first();
        if($request->input('featured') == 1) {
            $config->pickup_addresses()->where('addresses.id', '!=', $address->id)->update(['featured' => 0]);
        }
        $address->update($request->all());
        return BaseResponse::success([
            'message' => 'Cập nhật địa chỉ thành công'
        ]);
    }

    public function store(Request $request) {
        $ward = Ward::with('district.province')->find($request->input('ward_id'));
        $request->merge([
            'district_id' => $ward->district->id,
            'province_id' => $ward->district->province->id,
            'featured' => $request->input('featured') == 'on' ? 1 : '0'
        ]);
        $config = Config::select('id')->first();
        if($request->input('featured') == 1) {
            $config->pickup_addresses()->update(['featured' => 0]);
        }
        $config->pickup_addresses()->create($request->all());
        return BaseResponse::success([
            'message' => 'Cập nhật địa chỉ thành công'
        ]);
    }
}
