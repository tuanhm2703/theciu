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
        if(StorageService::exists($this->path)) {
            $url = asset('storage/'.$this->path);
            return get_proxy_image_url($url);
        } else {
            return asset('img/image-not-available.png');
        }
    }
}
