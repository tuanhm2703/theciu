<?php

namespace App\Observers;

use App\Enums\MediaType;
use App\Jobs\MigrateThumbnail;
use App\Jobs\ResizeImageJob;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\StorageService;

class ImageObserver {
    public function creating(Image $image) {
        if($image->type === MediaType::IMAGE) {
            $imageSizeInfo = getimagesize(StorageService::url($image->path));
            $image->width = $imageSizeInfo[0];
            $image->height = $imageSizeInfo[1];
        }
    }
    public function created(Image $image) {
        foreach($image->imageable->image_sizes as $size) {
            dispatch(new ResizeImageJob($image, $size))->onQueue('resizeImage');
        }

        if (get_class($image->imageable) == Inventory::class) {
            dispatch(new ResizeImageJob($image, 100))->onQueue('resizeImage');
        }
        if (get_class($image->imageable) == Product::class) {
            dispatch(new ResizeImageJob($image, 30))->onQueue('resizeImage');
        }
        if ($image->type === MediaType::VIDEO) {
            dispatch(new MigrateThumbnail($image))->onQueue('resizeImage');
        }
    }

    public function deleted(Image $image) {
        if (get_class($image->imageable) == Customer::class) {
            foreach($image->imageable->image_sizes as $size) {
                StorageService::delete("$size/$image->path");
            }
        }
    }
}
