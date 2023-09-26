<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function viewChangeAddressWithOutLogin(Request $request) {
        $selected_address_id = $request->selected_address_id;
        $addresses = getSessionAddresses();
        return view('landingpage.layouts.pages.profile.address.change', compact('addresses', 'selected_address_id'));
    }
}
