<?php

namespace App\Responses\Admin;

class BaseResponse {
    public static function success($data) {
        return response()->json([
            'data' => $data
        ]);
    }

    public static function error($data, $code = 500) {
        $code = $code == 0 || $code > 500 ? 500 : $code;
        $message = $code == 500 ? trans('errors.http_error.500') : '';
        $data['message'] = $message;
        return response()->json([
            $data
        ], $code);
    }
}
