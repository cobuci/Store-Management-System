<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('api_key');
        $apiToken = env('API_TOKEN');

        if (!$token || $token !== "Bearer $apiToken") {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }



        return $next($request);
    }
}
