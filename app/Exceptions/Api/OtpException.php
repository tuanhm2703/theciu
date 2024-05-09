<?php

namespace App\Exceptions\Api;

use App\Responses\Api\BaseResponse;
use Exception;

class OtpException extends Exception
{
    public function render()
    {
        return BaseResponse::error([
            'message' => $this->getMessage()
        ], 400);
    }

}
