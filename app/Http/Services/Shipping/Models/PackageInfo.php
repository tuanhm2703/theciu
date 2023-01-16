<?php

namespace App\Http\Services\Shipping\Models;

class PackageInfo {
    public $weight;
    public $length;
    public $height;
    public $width;
    const MAX_WIDTH = 50;
    const MAX_HEIGHT = 50;
    CONST MAX_LENGTH = 50;
    CONST MAX_WEIGHT = 20000;
    public function __construct($weight, $length, $height, $width) {
        $this->weight = $weight;
        $this->length = $length;
        $this->height = $height;
        $this->width = $width;
    }

    public function toArray() {
        return (array) $this;
    }
}
