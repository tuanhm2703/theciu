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
        $combo_banners = Banner::available()->orderBy('order')->combo()->get();
        return view('landingpage.layouts.pages.combo.index', compact('combos', 'combo_banners'));
    }
}
