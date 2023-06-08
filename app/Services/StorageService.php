<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService extends Storage {
    public static function getPathWithSize($size, $path) {
        return parent::url("$size/$path");
    }
}
