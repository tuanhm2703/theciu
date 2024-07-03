<?php

namespace App\Models;

use App\Enums\BlogType;
use App\Traits\Common\Categorizable;
use App\Traits\Common\EditedBy;
use App\Traits\Common\Imageable;
use App\Traits\Common\Wishlistable;
use App\Traits\Scopes\BlogScope;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model {
    use HasFactory, SoftDeletes, Imageable, Categorizable, BlogScope, CustomScope, EditedBy, Wishlistable;
    protected $fillable = [
        'title',
        'description',
        'content',
        'publish_date',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'slug',
        'type',
        'yoast_head',
        'author_name',
        'thumbnail'
    ];
    protected $casts = [
        'publish_date' => 'datetime'
    ];

    public function getMetaTags() {
        $tags = array(
            array(
                "name" => "description",
                "content" =>  "$this->description"
            ),
            array(
                "name" => "keywords",
                "content" => implode(', ', $this->categories()->pluck('name')->toArray())
            ),
            array(
                "property" => "og:title",
                "content" => getAppName() . " - $this->title"
            ),
            array(
                "property" => "og:description",
                "content" => "$this->description"
            ),
            array(
                "property" => "og:image",
                "content" => optional($this->image)->path_with_domain
            ),
            array(
                "property" => "og:url",
                "content" => route('client.blog.details', $this->slug)
            ),
            array(
                "property" => "og:type",
                "content" => "article"
            ),
            array(
                "name" => "twitter:card",
                "content" => "summary"
            ),
            array(
                "name" => "twitter:title",
                "content" => "$this->name"
            ),
            array(
                "name" => "twitter:description",
                "content" => "$this->description"
            ),
            array(
                "name" => "twitter:image",
                "content" => optional($this->image)->path_with_domain
            )
        );
        $output = '';
        foreach ($tags as $tag) {
            $content = [];
            foreach ($tag as $key => $meta) {
                $content[] = "$key='$meta'";
            }
            $output .= "<meta " . implode(" ", $content) . ">";
        }
        return $output;
    }

    public function scopeCareer($q) {
        return $q->whereType(BlogType::CAREER);
    }
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
