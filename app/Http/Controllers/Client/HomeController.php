<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $blogs = Blog::available()->with('image', 'categories')->get();
        return view('landingpage.layouts.pages.home.index', compact('blogs'));
    }

    public function about() {
        return view('landingpage.layouts.pages.about.index');
    }
}
