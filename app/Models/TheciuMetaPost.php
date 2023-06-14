<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheciuMetaPost extends Model
{
    protected $connection= 'thec_blog';
    protected $table = 'wpjk_postmeta';

    protected $primaryKey = 'meta_id';
    use HasFactory;

    public function post() {
        return $this->belongsTo(TheciuBlog::class);
    }

    public function meta() {
        return $this->belongsTo(TheciuMetaPost::class, 'meta_value', 'meta_id');
    }

    public function meta_attachment() {
        return $this->belongsTo(TheciuMetaPost::class, 'meta_value', 'post_id')->where('meta_key', '_wp_attached_file');
    }
}
