<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateVietGuysRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class VietGuysController extends Controller
{
    public function index() {
        $setting = app()->get('VietGuysConfig');
        return view('admin.pages.setting.vietguys.index', compact('setting'));
    }

    public function update(UpdateVietGuysRequest $request) {
        $input = $request->all();
        $input['data']['access_token'] = app()->get('VietGuysAccessToken');
        Setting::updateOrCreate([
            'name' => 'vietguys_config'
        ], $input);
        session()->flash('success', 'Cập nhật cấu hình VietGuys thành công!');
        return back();
    }
}
