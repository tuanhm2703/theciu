<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService extends Storage {
    public static function getPathWithSize($size, $path) {
        return parent::url("$size/$path");
    }

    public static function exists($path)
    {
        return true;
        if(env('APP_ENV') == 'local') return true;
        return parent::exists($path);
    }
}
