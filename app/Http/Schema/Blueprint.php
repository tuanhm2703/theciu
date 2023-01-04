<?php

namespace App\Http\Schema;

use Illuminate\Database\Schema\Blueprint as SchemaBlueprint;

class Blueprint extends SchemaBlueprint {
    public function followActionBy() {
        $this->bigInteger('created_by');
        $this->bigInteger('updated_by');
        $this->bigInteger('deletd_by');
    }
}
