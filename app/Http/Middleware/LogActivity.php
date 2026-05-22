<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use App\Models\ApiUsage;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log API requests and authenticated requests
        if ($request->is('api/*') && auth()->check()) {
            $user = auth()->user();
            $endpoint = $request->path();
            $method = $request->method();
            $statusCode = $response->getStatusCode();
            $ipAddress = $request->ip();
            $userAgent = $request->userAgent();

            // Log activity
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'api_call',
                'endpoint' => $endpoint,
                'method' => $method,
                'status_code' => $statusCode,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'metadata' => [
                    'query_params' => $request->query(),
                    'response_time' => microtime(true),
                ],
            ]);

            // Track API usage
            ApiUsage::track($user->id, $endpoint);

            // Update user's last login
            if ($method === 'GET' && $endpoint === 'api/v1/geo/provinces') {
                $user->update(['last_login_at' => now()]);
            }
        }

        return $response;
    }
}
