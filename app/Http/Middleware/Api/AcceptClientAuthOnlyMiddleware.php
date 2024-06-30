<?php

namespace App\Http\Middleware\Api;

use App\Enums\ApiExceptionCode;
use App\Enums\CustomerAuthType;
use App\Exceptions\Api\ApiException;
use App\Models\Customer;
use App\Responses\Api\BaseResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptClientAuthOnlyMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (requestUser() && requestUser() instanceof Customer && requestUser()->auth_type === CustomerAuthType::CLIENT) {
            return $next($request);
        }
        if (requestUser() && requestUser() instanceof Customer && requestUser()->auth_type === CustomerAuthType::DEVICE) {
            return BaseResponse::error([
                'message' => 'Unauthenticated',
                'code' => ApiExceptionCode::ONLY_ACCEPT_CLIENT_AUTH
            ], 401);
        }
        throw new ApiException("Unauthenticated", 401);
    }
}
