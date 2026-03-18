<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the origin header from the request
        $origin = $request->header('Origin');
        
        // Allowed origins
        $allowedOrigins = [
            'http://localhost:3000',
            'http://localhost:3001',
            'http://127.0.0.1:3000',
            'http://127.0.0.1:3001',
        ];

        // Check if origin is allowed
        $isAllowedOrigin = in_array($origin, $allowedOrigins);

        // Handle preflight requests (OPTIONS)
        if ($request->isMethod('OPTIONS')) {
            if ($isAllowedOrigin) {
                return response('', 204)
                    ->header('Access-Control-Allow-Origin', $origin)
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                    ->header('Access-Control-Max-Age', '3600');
            }
            abort(403, 'Origin not allowed');
        }

        // Process the actual request
        $response = $next($request);

        // Add CORS headers to the response
        if ($isAllowedOrigin) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        return $response;
    }
}
