<?php

namespace App\Observers;

use App\Jobs\ResizeImageJob;
use App\Models\Image;
use App\Models\Inventory;

class ImageObserver
{
    public function created(Image $image) {
        dispatch(new ResizeImageJob($image, $image->getImageableSize()))->onQueue('resizeImage');
        if(get_class($image->imageable) == Inventory::class) {
            dispatch(new ResizeImageJob($image, 100))->onQueue('resizeImage');
        }
    }
}
