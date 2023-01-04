<?php

namespace App\Models;

use App\Traits\Common\CommonFunc;
use App\Traits\Scopes\CustomScope;
use App\Traits\Scopes\PromotionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Promotion extends Model {
    use HasFactory, CustomScope, CommonFunc, PromotionScope;

    protected $fillable = [
        'name',
        'from',
        'to',
        'status',
        'type',
        'slug',
        'updated_at'
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'promotion_product');
    }

    public function generateUniqueSlug() {
        $base_slug = Str::snake(stripVN($this->name), '-');
        $slug = $base_slug;
        while(Category::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = "$base_slug-".now()->timestamp;
        }
        return $slug;
    }

    public function getTimeLeftAttribute() {
        return $this->to->diffInSeconds(now());
    }
}
