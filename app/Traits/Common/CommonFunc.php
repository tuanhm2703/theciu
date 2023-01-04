<?php

namespace App\Traits\Common;

use App\Enums\StatusType;

trait CommonFunc {
    public function isActive() {
        return $this->status == StatusType::ACTIVE;
    }

    public function isInactive() {
        return $this->status == StatusType::INACTIVE;
    }
}
