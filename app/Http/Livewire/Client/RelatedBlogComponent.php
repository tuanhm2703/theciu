<?php

namespace App\Http\Livewire\Client;

use App\Models\Blog;
use Livewire\Component;

class RelatedBlogComponent extends Component {
    public $blog;
    public $blogs;

    public function mount() {
        $this->blogs = Blog::whereHas('categories', function ($q) {
            $q->whereIn('categories.id', $this->blog->categories->pluck('id')->toArray());
        })->with('image', 'categories')->where('blogs.id', '!=', $this->blog->id)->get();
    }

    public function render() {
        return view('livewire.client.related-blog-component');
    }
}
