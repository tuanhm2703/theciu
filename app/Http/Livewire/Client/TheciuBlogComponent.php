<?php

namespace App\Http\Livewire\Client;

use App\Models\TheciuBlog;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TheciuBlogComponent extends Component {
    public $leftBlogs;
    public $rightBlogs;

    public function mount() {
        try {
            $this->leftBlogs = TheciuBlog::where('post_type', 'post')->where('ping_status', 'open')
                ->whereHas('meta_attachment')
                ->with('meta_attachment', function ($q) {
                    return $q->with('meta_attachment');
                })
                ->where('post_status', 'publish')
                ->orderBy('post_date', 'desc')
                ->limit(5)->get();
            $this->rightBlogs = TheciuBlog::where('post_type', 'post')
                ->where('ping_status', 'open')
                ->whereHas('meta_attachment')
                ->with('meta_attachment', function ($q) {
                    return $q->with('meta_attachment');
                })
                ->where('post_status', 'publish')
                ->orderBy('post_date', 'desc')
                ->whereNotIn('ID', $this->leftBlogs->pluck('ID')->toArray())
                ->limit(10)->get();
        } catch (\Throwable $th) {
            $this->leftBlogs = new Collection();
            $this->rightBlogs = new Collection();
        }
    }
    public function render() {
        return view('livewire.client.theciu-blog-component');
    }
}
