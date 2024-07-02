<?php

namespace App\Http\Services\Logger;

use Illuminate\Support\Facades\Log;
use Throwable;

class Logger {
    private string $channel = '';
    public function error(Throwable $e) {
        Log::channel($this->channel)->error($e->getMessage(), [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
}
