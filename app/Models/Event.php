<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use App\Traits\Common\Wishlistable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory, Imageable, Wishlistable;

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
        while (Event::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = "$base_slug-" . now()->timestamp;
        }
        return $slug;
    }

    public function scopePassed($query) {
        return $query->whereRaw('`to` < now()');
    }

    public function scopeIncomming($query) {
        return $query->whereRaw('`from` > now()');
    }

    public function scopeFilterByDate($query, string $date) {
        return $query->whereRaw("'$date' between events.from and events.to");
    }
}
