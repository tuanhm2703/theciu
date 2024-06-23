<?php

namespace App\Exceptions\Api;

use App\Responses\Api\BaseResponse;
use Exception;

class ApiException extends Exception {
    public function render() {
        return BaseResponse::error([
            'message' => $this->message
        ], 400);
    }
}
