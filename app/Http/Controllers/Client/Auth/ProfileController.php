<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth('customer')->user();
        return view('landingpage.layouts.pages.profile.profile', compact('user'));
    }

    public function password()
    {
        return view('landingpage.layouts.pages.profile.password');
    }
    public function phone()
    {
        return view('landingpage.layouts.pages.profile.phone');
    }
}
