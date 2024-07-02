<?php

namespace App\Exceptions\Api;

use App\Responses\Api\BaseResponse;
use Exception;

class CheckoutException extends Exception
{
    public function render() {
        return BaseResponse::error([
            'message' => $this->message
        ], $this->code ? $this->code : 400);
    }
}
