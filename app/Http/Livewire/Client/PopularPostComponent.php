<?php

namespace App\Http\Livewire\Client;

use App\Models\Blog;
use Livewire\Component;

class PopularPostComponent extends Component
{
    public $blogs;

    public $blog;

    public function mount() {
        $this->blogs = Blog::available()->orderBy('created_at', 'desc')->with('image', 'categories')->limit(4);
        if($this->blog) $this->blogs->where('id', '!=', $this->blog->id);
        $this->blogs = $this->blogs->get();
    }

    public function render()
    {
        return view('livewire.client.popular-post-component');
    }
}
