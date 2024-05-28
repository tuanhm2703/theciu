<?php

namespace App\Http\Services\SMSService\Exceptions;

use App\Responses\Api\BaseResponse;
use Exception;

class ZNSException extends Exception {
    public function render()
    {
        return BaseResponse::error([
            'message' => $this->getMessage()
        ], 400);
    }
}
