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
        'type',
        'begin',
        'end'
    ];

    protected $casts = [
        'begin',
        'end'
    ];
    public function getImageSizesAttribute() {
        return [
            2500
        ];
    }
    const DEFAULT_IMAGE_SIZE = 2500;

    public function scopeBanner($q) {
        return $q->where('type', BannerType::BANNER);
    }
    public function scopePopup($q) {
        return $q->where('type', BannerType::POPUP);
    }

    public function scopeAvailable($q) {
        return $q->active()->where(function($q) {
            $q->whereRaw('now() between begin and end')->orWhere(function($q) {
                $q->whereNull('begin')->WhereNull('end');
            })->orWhere(function($q) {
                $q->whereNull('begin')->whereRaw('now() < end');
            })->orWhere(function($q) {
                $q->whereNull('end')->whereRaw('now() > begin');
            });
        });
    }
}
