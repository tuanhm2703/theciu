<?php

namespace App\Http\Middleware;

use App\Models\ShippingService;
use Closure;
use Illuminate\Support\Facades\Log;

class WhitelistIpAddressShippingMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (env('APP_ENV') != 'prod') return $next($request);
        $ip_addresses = ShippingService::pluck('ip_address')->toArray();
        $ips = [];
        foreach ($ip_addresses as $ip_address) {
            $service_ips = explode(',', $ip_address);
            $ips = array_merge($ips, $service_ips);
        }
        $remote_ips = explode(", ", $request->ip());
        foreach ($remote_ips as $ip) {
            if (in_array($ip, $ips)) return $next($request);
        }
        abort(403, "You are restricted to access the site.");
    }
}
