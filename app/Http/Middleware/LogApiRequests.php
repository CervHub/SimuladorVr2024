<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Log;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        // Proceed with the request
        $response = $next($request);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Log the request and response
        try {
            ApiLog::create([
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'request_payload' => $request->all(),
                'response_payload' => json_decode($response->getContent(), true),
                'status_code' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'execution_time' => $executionTime,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log API request: ' . $e->getMessage());
        }

        return $response;
    }
}
