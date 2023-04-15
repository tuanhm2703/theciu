<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index() {
        $setting = Setting::getWebsiteSetting();
        $setting->header_code = $setting->data['header_code'];
        $setting->footer_code = $setting->data['footer_code'];
        return view('admin.pages.setting.website.index', compact('setting'));
    }

    public function update(Request $request) {
        $setting = Setting::getWebsiteSetting();
        $setting->update([
            'data' => $request->all()
        ]);
        return redirect()->back();
    }
}
