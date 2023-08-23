<?php

namespace App\Models;

use App\Enums\BannerType;
use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {
    use HasFactory, SoftDeletes, Imageable, CustomScope;
    protected $fillable = [
        'title',
        'description',
        'url',
        'order',
        'status',
        'type'
    ];
    public function getImageSizesAttribute() {
        return [
            1600
        ];
    }
    const DEFAULT_IMAGE_SIZE = 1600;

    public function scopeBanner($q) {
        return $q->where('type', BannerType::BANNER);
    }
    public function scopePopup($q) {
        return $q->where('type', BannerType::POPUP);
    }
}
