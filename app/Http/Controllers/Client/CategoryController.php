<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function viewCategoryTypeProduct($type) {
        $title = trans("labels.$type");
        return view('landingpage.layouts.pages.product.index', compact('type', 'title'));
    }
    public function viewProductCategory($category) {
        return view('landingpage.layouts.pages.product.index', compact('category'));
    }
}
