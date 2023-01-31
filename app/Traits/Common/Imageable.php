<?php

namespace App\Traits\Common;

use App\Enums\MediaType;
use App\Models\Image;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait Imageable {
    public function images() {
        return $this->morphMany(Image::class, 'imageable')->where(function($q) {
            $q->where('type', '!=', MediaType::VIDEO)->orWhere('type', null);
        })->orderBy('order', 'asc');
    }
    public function image() {
        return $this->morphOne(Image::class, 'imageable')->where(function($q) {
            $q->where('type', '!=', MediaType::VIDEO)->orWhere('type', null);
        })->orderBy('order', 'asc');
    }

    public function createImages($images, $type = null, $folder = 'images') {
        $records = [];
        foreach ($images as $image) {
            $fileName = $image->getClientOriginalName();
            $path = StorageService::put($folder, $image);
            $records[] = [
                'name' => $fileName,
                'path' => $path,
                'type' => $type
            ];
        }
        $this->images()->createMany($records);
    }

    public function createImagesFromUrls(Array $urls, $type = null, $folder = 'images') {
        $records = [];
        foreach($urls as $url) {
            $basename = pathinfo($url)['basename'];
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
}
