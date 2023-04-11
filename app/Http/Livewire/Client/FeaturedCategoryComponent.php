<?php

namespace App\Http\Livewire\Client;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class FeaturedCategoryComponent extends Component
{
    public $featured_categories;

    public function mount() {
        $this->featured_categories = Cache::remember('featured_categories', env('CACHE_EXPIRE', 600), function() {
            return Category::whereHas('image')->with('image')->where('type', CategoryType::FEATURED)->active()->get();
        });
    }
    public function render()
    {
        return view('livewire.client.featured-category-component');
    }
}
