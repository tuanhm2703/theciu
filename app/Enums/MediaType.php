<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class MediaType extends Enum {
    const VIDEO = 'video';
    const IMAGE = 'image';
    const SIZE_RULE = 'size_rule';
    const AVATAR = 'avatar';
    const PHONE = 'phone';
    const PDF = 'pdf';
}
