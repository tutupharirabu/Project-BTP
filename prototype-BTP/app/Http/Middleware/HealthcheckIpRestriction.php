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
            '0.0.0.0',
            '127.0.0.1',
            '::1',
            '100.91.219.109',
            '10.0.1.3',       // IP Docker container yang aktual
            '10.0.0.0/8',     // Atau allow semua range 10.x.x.x
        ];

        if (!in_array($request->ip(), $allowedIps)) {
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
