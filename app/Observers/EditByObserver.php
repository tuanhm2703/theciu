<?php

namespace App\Observers;

use Carbon\Carbon;

class EditByObserver {
    public function creating($model) {
        $model->created_by = auth()->check() ? auth()->user()->id : null;
    }

    public function updating($model) {
        $model->updated_by = auth()->check() ? auth()->user()->id : null;
    }

    public function deleting($model) {
        $model->deleted_by = auth()->check() ? auth()->user()->id : null;
    }
}
