<?php

namespace App\Responses\Api;

class BaseResponse {
    public static function success($data) {
        return response()->json([
            'data' => $data
        ]);
    }

    public static function error($data = [], $code = 400) {
        $code = $code == 0 || $code > 500 ? 500 : $code;
        $message = $code == 500 ? trans('errors.http_error.500') : '';
        $code = $code == 500 ? 400 : $code;
        return response()->json($data, $code);
    }

    public static function successWithRawData($data) {
        return response()->json($data);
    }
}
