<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateAddressRequest;
use App\Http\Requests\Api\UpdateAddressRequest;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class AddressController extends Controller {
    public function provinces() {
        return BaseResponse::success(Province::orderBy('name', 'desc')->select('id', 'name_with_type')->get());
    }

    public function districts(Request $request) {
        return BaseResponse::success(District::where('parent_id', $request->province_id)->orderBy('name', 'desc')->select('id', 'name_with_type')->get());
    }

    public function wards(Request $request) {
        return BaseResponse::success(Ward::where('parent_id', $request->district_id)->orderBy('name', 'desc')->select('id', 'name_with_type')->get());
    }

    public function addresses() {
        $user = requestUser();
        $addresses = $user->shipping_addresses()->select('id', 'type', 'details', 'province_id', 'ward_id', 'district_id', 'full_address', 'phone', 'featured', 'fullname')->get();
        return BaseResponse::success($addresses);
    }

    public function store(CreateAddressRequest $request) {
        $user = requestUser();
        $data = $request->validated();
        $address = $user->addresses()->create($data);
        if($request->featured) {
            $user = requestUser();
            $user->shipping_addresses()->where('addresses.id', '!=', $address->id)->update(['featured' => 0]);
        }
        return BaseResponse::success([
            'message' => 'Tạo địa chỉ thành công'
         ]);
    }

    public function update(UpdateAddressRequest $request, Address $address) {
        $address->update($request->validated());
        if($request->featured) {
            $user = requestUser();
            $user->shipping_addresses()->where('addresses.id', '!=', $address->id)->update(['featured' => 0]);
        }
        return BaseResponse::success([
           'message' => 'Cập nhật địa chỉ thành công'
        ]);
    }

    public function destroy(Address $address) {
        $address->delete();
        return BaseResponse::success([
            'message' => 'Xoá địa chỉ thành công'
        ]);
    }
}
