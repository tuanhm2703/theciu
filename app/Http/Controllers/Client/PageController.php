<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function details($slug) {
        $page = Page::whereSlug($slug)->firstOrFail();
        return view('landingpage.layouts.pages.page.details', compact('page'));
    }
}
