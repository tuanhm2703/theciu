<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function paginate() {
        $pages = Page::query();
        return DataTables::of($pages)
        ->addColumn('action', function($page) {
            return view('admin.pages.page.components.action', compact('page'));
        })
        ->make(true);
    }
}
