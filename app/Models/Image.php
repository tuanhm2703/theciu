<?php

namespace App\Models;

use App\Services\StorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    use HasFactory;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'type',
        'path',
        'name',
        'size',
        'order'
    ];

    protected $appends = [
        'path_with_domain'
    ];

    public function getPathWithDomainAttribute() {
        return get_proxy_image_url(StorageService::url($this->path), $this->getImageableSize());
        if(StorageService::exists($this->path)) {
            return get_proxy_image_url(StorageService::url($this->path), $this->getImageableSize());
        } else {
            return asset('img/image-not-available.png');
        }
    }

    public function getImageableSize() {
        switch ($this->imageable_type) {
            case Banner::class:
                return 1200;
                break;
            default:
                return 600;
                break;
        }
    }
}
