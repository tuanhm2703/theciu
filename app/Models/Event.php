<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, Imageable;

    protected $fillable = [
        'name',
        'from',
        'to',
        'content',
        'image_section',
        'slug',
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'event_product');
    }

    public function generateUniqueSlug() {
        $base_slug = stripVN($this->name);
        $slug = $base_slug;
        while(Event::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = "$base_slug-".now()->timestamp;
        }
        return $slug;
    }
}
