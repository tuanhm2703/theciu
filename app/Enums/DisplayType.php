<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class DisplayType extends Enum {
    const PUBLIC = 'public';
    const PRIVATE = 'private';

    const SYSTEM = 'system';

    public static function getDisplayOptions() {
        return [
            static::PUBLIC => strtoupper(static::PUBLIC),
            static::PRIVATE => strtoupper(static::PRIVATE),
            static::SYSTEM => strtoupper(static::SYSTEM)
        ];
    }
}
