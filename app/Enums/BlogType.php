<?php

namespace App\Enums;

class BlogType {
    const WEB = 'web';
    const CAREER = 'career';

    public static function getBlogTypeOptions() {
        return [
            self::WEB => trans('labels.blogType.web'),
            self::CAREER => trans('labels.blogType.career')
        ];
    }
}
