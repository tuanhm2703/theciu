<?php

namespace App\Enums;

class BannerType {
    const BANNER = 'banner';
    const POPUP = 'popup';
    const COMBO = 'combo';
    const COLLECTION = 'collection';
    public static function getCollections() {
        return [
            static::BANNER,
            static::POPUP,
            static::COMBO,
            static::COLLECTION
        ];
    }

    public static function getOptions() {
        return [
            static::BANNER => static::BANNER,
            static::POPUP => static::POPUP,
            static::COMBO => static::COMBO,
            static::COLLECTION => static::COLLECTION
        ];
    }
}
