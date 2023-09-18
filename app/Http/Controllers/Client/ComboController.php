<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function index() {
        $combos = Combo::available()->get();
        $banners = Banner::available()->with('desktopImage', 'phoneImage')->orderBy('order')->combo()->get();
        return view('landingpage.layouts.pages.combo.index', compact('combos', 'banners'));
    }
}
