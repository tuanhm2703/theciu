<?php

namespace App\Observers;

use App\Jobs\ResizeImageJob;
use App\Models\Image;

class ImageObserver
{
    public function created(Image $image) {
        dispatch(new ResizeImageJob($image, $image->getImageableSize()))->onQueue('resizeImage');
    }
}
