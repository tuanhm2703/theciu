<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        auth()->user()->update($request->except('password'));
        session()->flash('success', 'Profile succesfully updated');
        return back();
    }

    public function updatePassword(Request $request) {

    }
}
