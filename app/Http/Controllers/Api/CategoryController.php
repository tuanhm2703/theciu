<?php

namespace App\Http\Controllers\Api;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function getAll() {
        return Category::whereNull('parent_id')
            ->with('image', 'categories:name,id,slug,parent_id', 'categories.categories:name,id,slug,parent_id')
            ->whereType(CategoryType::PRODUCT)
            ->orderBy('categories.name')
            ->select('id', 'name', 'slug')
            ->withCount('products')->get();
    }
}
