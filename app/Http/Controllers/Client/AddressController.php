<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Responses\Admin\BaseResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function viewChangeAddressWithOutLogin(Request $request) {
        $selected_address_id = $request->selected_address_id;
        $addresses = getSessionAddresses();
        return view('landingpage.layouts.pages.profile.address.change', compact('addresses', 'selected_address_id'));
    }

    public function destroy($id) {
        $addresses = getSessionAddresses();
        $addresses = $addresses->filter(function($address) use ($id){
            return $address->id != $id;
        });
        session()->put('addresses', serialize($addresses));
        return BaseResponse::success([
            'message' => 'Xoá địa chỉ thành công'
        ]);
    }
}
