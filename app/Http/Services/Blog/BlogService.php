<?php

namespace App\Http\Services\Blog;

use App\Enums\BlogType;
use App\Enums\CategoryType;
use App\Models\Blog;
use App\Models\Category;
use GuzzleHttp\Client;

class BlogService {
    private Client $client;
    public function __construct() {
        $this->client = new Client([
            'base_uri' => 'https://theciu.vn/blog/wp-json/wp/v2/'
        ]);
    }
    public function syncBlogs() {
        $authors = collect($this->getAuthors());
        $categories = collect($this->syncBlogCategories());
        $data = $this->getBlogFromApi(1, 1);
        $total = $data['total'];
        $numOfPages = round($total / 100);
        for ($i = 1; $i <= $numOfPages; $i++) {
            $data = $this->getBlogFromApi(100, $i);
            $blogs = $data['items'];
            foreach ($blogs as $blog) {
                $newBlog = Blog::updateOrCreate([
                    'slug' => $blog->slug
                ], [
                    'title' => $blog->title->rendered,
                    'description' => $blog->excerpt->rendered,
                    'content' => $blog->content->rendered,
                    'yoast_head' => $blog->yoast_head,
                    'thumbnail' => $blog->yoast_head_json->og_image[0]->url,
                    'publish_date' => $blog->date,
                    'type' => BlogType::WEB,
                    'author_name' => $authors->where('id', $blog->author)->first()?->name
                ]);
                $category_names = $categories->whereIn('id', $blog->categories)->pluck('name')->toArray();
                $category_ids = Category::whereIn('name', $category_names)->pluck('id')->toArray();
                $newBlog->categories()->sync($category_ids);
            }
        }
    }

    public function getAuthors() {
        $response = $this->client->get('users', [
            'query' => [
                'per_page' => 100
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function syncBlogCategories() {
        $response = $this->client->get('categories', [
            'query' => [
                'per_page' => 100
            ]
        ]);
        $categories = json_decode($response->getBody()->getContents());
        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category->name,
                'type' => CategoryType::BLOG
            ]);
        }
        return $categories;
    }

    public function getBlogFromApi(int $pageSize, int $page) {
        $response = $this->client->get('posts', [
            'query' => [
                'per_page' => $pageSize,
                'page' => $page
            ]
        ]);
        return [
            'total' => $response->getHeader('X-WP-Total')[0],
            'items' => json_decode($response->getBody()->getContents())
        ];
    }

    private function getBlogFromApiById(string|int $id) {
        $blog = $this->client->get("posts/$id");
        return json_decode($blog->getBody()->getContents());
    }

    public function syncByBlogId(string|int $id) {
        $authors = collect($this->getAuthors());
        $categories = collect($this->syncBlogCategories());
        $blog = $this->getBlogFromApiById($id);
        $newBlog = Blog::updateOrCreate([
            'slug' => $blog->slug
        ], [
            'title' => $blog->title->rendered,
            'description' => $blog->excerpt->rendered,
            'content' => $blog->content->rendered,
            'yoast_head' => $blog->yoast_head,
            'thumbnail' => $blog->yoast_head_json->og_image[0]->url,
            'publish_date' => $blog->date,
            'type' => BlogType::WEB,
            'author_name' => $authors->where('id', $blog->author)->first()?->name
        ]);
        $category_names = $categories->whereIn('id', $blog->categories)->pluck('name')->toArray();
        $category_ids = Category::whereIn('name', $category_names)->pluck('id')->toArray();
        $newBlog->categories()->sync($category_ids);
    }

    public function deleteLocalBlogByApiBlogId(string|int $id) {
        $blog = $this->getBlogFromApiById($id);
        Blog::whereSlug($blog->slug)->delete();
    }
}
