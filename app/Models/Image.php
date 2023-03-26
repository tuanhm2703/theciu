<?php

namespace App\Models;

use App\Enums\MediaType;
use App\Services\StorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

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
        'path_with_domain',
        'path_with_original_size'
    ];

    public function getPathWithDomainAttribute() {
        return StorageService::url($this->path);
        if ($this->type == MediaType::VIDEO) {
            return StorageService::url($this->path);
        } else {
            try {
                if (StorageService::exists($this->path) || isNavActive('admin')) {
                    if (isNavActive('admin.product.edit')) {
                        return StorageService::url($this->path);
                    }
                    return get_proxy_image_url(StorageService::url($this->path), $this->getImageableSize());
                }
            } catch (\Throwable $th) {
                return asset('img/image-not-available.png');
            }
            return asset('img/image-not-available.png');
        }
    }

    public function getPathWithOriginalSizeAttribute() {
        if(StorageService::exists($this->path)) {
            return StorageService::url($this->path);
        }
        return asset('img/image-not-available.png');
    }

    public function getImageableSize() {
        switch ($this->imageable_type) {
            case Banner::class:
                return 1600;
                break;
            default:
                return 600;
                break;
        }
    }
}
