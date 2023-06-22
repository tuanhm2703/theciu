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
        'order',
        'width',
        'height'
    ];

    protected $appends = [
        'path_with_domain',
        'path_with_original_size',
        'product_lazy_load_path'
    ];

    public function imageable() {
        return $this->morphTo();
    }

    public function getPathWithDomainAttribute() {
        if ($this->type == MediaType::VIDEO) {
            return StorageService::url($this->path);
        } else {
            try {
                if (StorageService::exists($this->path) || isNavActive('admin')) {
                    if (isNavActive('admin.product.edit') || isNavActive('admin.ajax.product.inventories')) {
                        return StorageService::url($this->path);
                    }
                    $size = $this->getImageableSize();
                    return StorageService::url("$size/$this->path");
                }
            } catch (\Throwable $th) {
                return asset('img/image-not-available.png');
            }
            return asset('img/image-not-available.png');
        }
    }

    public function getPathWithSize($size) {
        if(StorageService::exists("$size/$this->path")) {
            return StorageService::url("$size/$this->path");
        } else if(StorageService::exists($this->path)) {
            return StorageService::url($this->path);
        }
        return asset('img/image-not-available.png');
    }

    public function getPathWithOriginalSizeAttribute() {
        if(StorageService::exists($this->path)) {
            return StorageService::url($this->path);
        }
        return asset('img/image-not-available.png');
    }
    public function getProductLazyloadPathAttribute() {
        return getPathWithSize(30, $this->path);
    }
    public function getImageBySize() {

    }

    public function getImageableSize() {
        switch ($this->imageable_type) {
            case Banner::class:
                return 1600;
                break;
            default:
                return 1000;
                break;
        }
    }
}
