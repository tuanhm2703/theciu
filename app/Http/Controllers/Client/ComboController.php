<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function index() {
        $combos = Combo::available()->get();
        return view('landingpage.layouts.pages.combo.index', compact('combos'));
    }
}
