<?php

namespace App\Traits\Common;

use App\Models\Action;

trait Actionable {
    public function action() {
        return $this->morphOne(Action::class, 'actionable');
    }
}
