<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class CheckCustomerPhoneVerifyStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(FacadesRequest::route()->getName() == 'client.auth.profile.phone') return $next($request);
        if (auth('customer')->check()) {
            if (customer()->phone_verified)
                return $next($request);
            else return redirect()->route('client.auth.profile.phone', ['update' => false]);
        }
        return $next($request);
    }
}
