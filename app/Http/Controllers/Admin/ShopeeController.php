<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ShopeeService\ShopeeService;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShopeeController extends Controller {
    public function index() {
        $setting = Setting::getShopeeSettings();
        return view('admin.pages.setting.shopee.index', compact('setting'));
    }

    public function authShop() {
        $host = "https://partner.shopeemobile.com";
        $path = "/api/v2/shop/auth_partner";
        $redirectUrl = route('admin.setting.shopee.auth.redirect');

        $timest = time();
        $shopeeSetting = Setting::getShopeeSettings()->data;
        $baseString = sprintf("%s%s%s", $shopeeSetting['partnerId'], $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $shopeeSetting['partnerKey']);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&redirect=%s", $host, $path, $shopeeSetting['partnerId'], $timest, $sign, $redirectUrl);
        return redirect($url);
    }

    public function update(Request $request) {
        Setting::updateOrCreate([
            'name' => 'shopee'
        ], $request->all());
        session()->flash('success', 'Cập nhật cấu hình Shopee thành công!');
        return back();
    }

    public function authRedirect(Request $request) {
        Setting::updateOrCreate([
            'name' => 'shopee_credentials'
        ], [
            'data' => [
                'code' => $request->code,
                'main_account_id' => $request->main_account_id
            ]
        ]);
        (new ShopeeService())->updateAccessToken($request->code, $request->main_account_id);
        session()->flash('success', 'Xác minh tài khoản shopee thành công');
        return redirect()->route('admin.setting.shopee.index');
    }
}
