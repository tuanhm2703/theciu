<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheciuBlog extends Model
{
    protected $connection= 'thec_blog';
    protected $table = 'wpjk_posts';

    protected $primaryKey = 'ID';
    use HasFactory;

    public function meta_posts() {
        return $this->hasMany(TheciuMetaPost::class, 'post_id');
    }
    public function meta_attachment() {
        return $this->hasOne(TheciuMetaPost::class, 'post_id')->where('meta_key', '_thumbnail_id');
    }
    public function getThumbnailAttribute() {
        return "https://theciu.vn/blog/wp-content/uploads/".$this->meta_attachment?->meta_attachment->meta_value;
    }
    public function getDetailUrlAttribute() {
        return route('client.blog.details', $this->post_name);
    }
}
