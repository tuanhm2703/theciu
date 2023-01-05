<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout() {
        auth('customer')->logout();
        return redirect()->back();
    }
}
