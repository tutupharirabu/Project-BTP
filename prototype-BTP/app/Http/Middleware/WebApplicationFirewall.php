<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

use App\Models\BlockedIp;

class WebApplicationFirewall
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = strtolower($request->userAgent());

        // Admin-controlled blacklist via table `blocked_ips`
        if (BlockedIp::where('ip_address', $ip)->exists()) {
            Log::warning("Blocked by admin-controlled blacklist", ['ip' => $ip]);
            return response()->view('errors.blocked_admin', ['ip' => $ip], 403);
        }

        // Static blocklist
        $blockedIps = ['203.0.113.45', '192.168.1.10', '192.168.1.100', '10.0.0.5'];
        if (in_array($ip, $blockedIps)) {
            Log::warning("Blocked static IP", ['ip' => $ip]);
            return response()->view('errors.blocked_static', ['ip' => $ip], 403);
        }

        // Temporary block from failed login
        $record = DB::table('failed_logins')->where('ip', $ip)->first();
        if ($record && $record->blocked_until && Carbon::now()->lt($record->blocked_until)) {
            Log::warning("Blocked temporary IP due to failed login", ['ip' => $ip]);
            return response()->view('errors.blocked_temp', [
                'ip' => $ip,
                'retryAt' => $record->blocked_until
            ], 429);
        }

        // SQL Injection detection
        $sqliPatterns = ['select', 'union', 'insert', 'drop', '--', ';', ' or ', '1=1'];
        foreach ($request->all() as $key => $value) {
            foreach ($sqliPatterns as $pattern) {
                if (is_string($value) && stripos($value, $pattern) !== false) {
                    Log::warning("SQL injection pattern detected", [
                        'ip' => $ip,
                        'key' => $key,
                        'value' => $value
                    ]);
                    abort(403, 'Suspicious input detected.');
                }
            }
        }

        // Bad bot detection
        $badAgents = ['curl', 'httpclient', 'scanner', 'sqlmap', 'nmap'];
        foreach ($badAgents as $bad) {
            if (str_contains($userAgent, $bad)) {
                Log::warning("Bad bot detected", ['ip' => $ip, 'userAgent' => $userAgent]);
                abort(403, 'Access denied.');
            }
        }

        // Payload size limit
        $contentLength = $request->headers->get('Content-Length');
        if ($contentLength && $contentLength > 50000) {
            Log::warning("Payload too large", ['ip' => $ip, 'length' => $contentLength]);
            abort(413, 'Payload too large');
        }

        return $next($request);
    }
}
