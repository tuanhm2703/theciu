<?php

namespace App\Enums;

class BannerType {
    const BANNER = 'banner';
    const POPUP = 'popup';

    public static function getCollections() {
        return [
            static::BANNER,
            static::POPUP
        ];
    }

    public static function getOptions() {
        return [
            static::BANNER => static::BANNER,
            static::POPUP => static::POPUP
        ];
    }
}
