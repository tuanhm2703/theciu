<?php

namespace App\Http\Livewire\Client;

use App\Models\Category;
use Livewire\Component;

class BlogCategoryListComponent extends Component {
    public $categories;

    public function mount() {
        $this->categories = Category::whereHas('blogs', function ($q) {
            $q->available();
        })->withCount('blogs')->orderBy('blogs_count', 'desc')->get();
    }

    public function render() {
        return view('livewire.client.blog-category-list-component');
    }
}
