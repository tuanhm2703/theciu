<?php

namespace App\Traits\Common;

use App\Enums\MediaType;
use App\Models\Image;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait Imageable {
    public function getImageSizesAttribute() {
        return [
            1000
        ];
    }
    public function images() {
        return $this->morphMany(Image::class, 'imageable')->where(function ($q) {
            $q->where('type', '!=', MediaType::VIDEO)->orWhere('type', null);
        })->orderBy('order', 'asc');
    }
    public function image() {
        return $this->morphOne(Image::class, 'imageable')->where(function ($q) {
            $q->where('type', '!=', MediaType::VIDEO)->orWhere('type', null);
        })->orderBy('order', 'asc')->orderBy('id', 'desc');
    }

    public function phoneImage() {
        return $this->morphOne(Image::class, 'imageable')->where('type', MediaType::PHONE);
    }
    public function desktopImage() {
        return $this->morphOne(Image::class, 'imageable')->where('type', null);
    }

    public function createImages($images, $type = null, $folder = 'images') {
        foreach ($images as $key => $image) {
            $fileName = $image->getClientOriginalName();
            $path = StorageService::put($folder, $image);
            if ($path) {
                $this->image()->create([
                    'name' => $fileName,
                    'path' => $path,
                    'type' => $type,
                    'order' => $key
                ]);
            }
        }
    }

    public function createImagesFromUrls(array $urls, $type = null, $folder = 'images') {
        set_time_limit(1);
        $records = [];
        foreach ($urls as $url) {
            $basename = pathinfo($url)['basename'];
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            if(strlen($basename) > 100) {
                if($extension != '') {
                    $basename = random_string(100).".$extension";
                } else {
                    $basename = random_string(100);
                }
            }
            $basename = $extension  == "" ? "$basename.jpeg" : $basename;
            $content = file_get_contents($url);
            Storage::put("$folder/$basename", $content);
            $records[] = [
                'name' => $basename,
                'path' => "$folder/$basename",
                'type' => $type
            ];
        }
        $this->images()->createMany($records);
    }

    public function video() {
        return $this->morphOne(Image::class, 'imageable')->where('type', MediaType::VIDEO);
    }

    public function avatar() {
        return $this->morphOne(Image::class, 'imageable')->where('type', MediaType::AVATAR);
    }
    public function getAvatarPathAttribute() {
        if ($this->avatar) {
            if(StorageService::exists($this->avatar->path)) {
                return $this->avatar->path_with_original_size;
            }
        }
        return asset('assets/images/default-avatar.png');
    }

    public function fixImages() {
        foreach($this->images as $image) {
            $image->fix();
        }
    }
}
