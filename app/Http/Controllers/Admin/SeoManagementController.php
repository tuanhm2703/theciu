<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SeoManagementController extends Controller {
    public function index() {
        $config = Config::firstOrCreate();
        $meta_tag = $config->metaTag()->firstOrCreate([
            'metable_id' => $config->id,
            'metable_type' => $config->getMorphClass()
        ], [
            'payload' => [
                'title' => config('meta.default_title'),
                'description' => config('meta.default_description'),
                'keywords' => config('meta.default_title'),
            ]
        ]);
        return view('admin.pages.setting.seo.index', compact('meta_tag'));
    }

    public function update(Request $request) {
        $meta_tag = App::get('AppConfig')->metaTag;
        $meta_tag->update([
            'payload' => $request->meta
        ]);
        return redirect()->back();
    }
}
