<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WriteLogMiddleware
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
        // Log::info('WriteLogMiddleware', [$request->method()]);
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'ip' => $request->ip(),
                'user_id' =>   auth('api')->user()->id,
                'route' => $request->path(),
                'method' => $request->method(),
                'data' => $request->all(),
                // 'url' => $request->url(),
                // 'token' => $request->bearerToken(),
            ]
        ]);

        return $next($request);
    }
}
