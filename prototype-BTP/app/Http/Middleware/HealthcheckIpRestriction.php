<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HealthcheckIpRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedIps = [
            '0.0.0.0',        // localhost
            '127.0.0.1',      // localhost
            '::1',            // localhost IPv6
            '100.91.219.109', // IP server Anda
        ];

        if (!in_array($request->ip(), $allowedIps)) {
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
