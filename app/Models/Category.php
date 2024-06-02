<?php

namespace App\Models;

use App\Enums\CategoryType;
use App\Traits\Common\Imageable;
use App\Traits\Common\Metable;
use App\Traits\Common\Wishlistable;
use App\Traits\Scopes\CategoryScope;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model {
    use HasFactory, SoftDeletes, Imageable, CategoryScope, CustomScope, Metable, Wishlistable;
    protected $fillable = [
        'name',
        'parent_id',
        'status',
        'type',
        'slug',
        'updated_at',
        'content',
        'order',
        'visible'
    ];

    public function categories() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function products() {
        return $this->morphedByMany(Product::class, 'categorizable');
    }
    public function available_products() {
        return $this->morphedByMany(Product::class, 'categorizable')->available();
    }

    public function blogs() {
        return $this->morphedByMany(Blog::class, 'categorizable');
    }

    public static function allActiveBlogCategories() {
        return Category::active()->where('type', CategoryType::BLOG)->get();
    }

    public function generateUniqueSlug() {
        $base_slug = stripVN($this->name);
        $slug = $base_slug;
        while (Category::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = "$base_slug-" . now()->timestamp;
        }
        return $slug;
    }
    public static function getMenuCategories() {
        return Category::whereNull('parent_id')->with('categories', function ($q) {
            $q->withCount('products')->with('categories', function ($q) {
                $q->withCount('products');
            });
        })->withCount('products')->where(function ($q) {
            $q->whereType(CategoryType::PRODUCT)->orWhere('type', CategoryType::COLLECTION);
        })->where('visible', 1)->orderBy('order')->get();
    }
    public function hasProducts() {
        if ($this->products_count == 0) {
            foreach ($this->categories as $c) {
                if ($c->hasProducts()) return true;
            }
        } else {
            return true;
        }
        return false;
    }

    public function getAllChildId() {
        $ids = [$this->id];
        if ($this->categories) {
            foreach ($this->categories as $c) {
                if ($c->id != $this->id) {
                    $ids = array_merge($ids, $c->getAllChildId());
                }
            }
        } else {
            return [$this->id];
        }
        return $ids;
    }

    public static function getCategoryOptionsGroupByType() {
        $types = Category::where('type', '!=', CategoryType::PRODUCT)->select('type')->groupBy('type')->get()->pluck('type')->toArray();
        $options = [];
        foreach ($types as $type) {
            $options[__('labels.' . $type)] = Category::where('type', $type)->pluck('name', 'id')->toArray();
        }
        return $options;
    }
}
