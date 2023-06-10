<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateSeoSlugForAll extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        ini_set('memory_limit', '-1');
        $products = Product::select('name', 'id', 'slug')->get();
        foreach ($products as $product) {
            $product->slug = stripVN($product->name);
            while (Product::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                $product->slug = stripVN($product->name)."-".now()->timestamp;
            }
            $product->save();
            unset($product);
        }
        $pages = Page::all();
        foreach ($pages as $page) {
            $page->slug = stripVN($page->title);
            while (Page::where('slug', $page->slug)->where('id', '!=', $page->id)->exists()) {
                $page->slug = stripVN($page->title)."-".now()->timestamp;
            }
            $page->save();
        }
        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            $blog->slug = stripVN($blog->title);
            while (Blog::where('slug', $blog->slug)->where('id', '!=', $blog->id)->exists()) {
                $blog->slug = stripVN($blog->title)."-".now()->timestamp;
            }
            $blog->save();
        }
        $promotions = Promotion::all();
        foreach ($promotions as $promotion) {
            $promotion->slug = stripVN($promotion->name);
            while (Promotion::where('slug', $promotion->slug)->where('id', '!=', $promotion->id)->exists()) {
                $promotion->slug = stripVN($promotion->name)."-".random_int(100000, 999999);
            }
            $promotion->save();
        }
        $this->info('Service created successfully!');
    }
}
