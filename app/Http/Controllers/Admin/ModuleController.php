<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller {
    public function index() {
        $modules = Module::all();
        return view('admin.pages.module.index', compact('modules'));
    }

    public function editRole() {
    }
}
