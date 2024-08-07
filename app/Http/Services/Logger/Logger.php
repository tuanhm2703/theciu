<?php

namespace App\Http\Services\Logger;

use Illuminate\Support\Facades\Log;
use Throwable;

class Logger {
    public string $channel = '';
    public function error(Throwable $e) {
        Log::channel($this->channel)->error($e);
    }
}
