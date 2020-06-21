<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $providedToken = trim($request->headers->get('token'));
        $storedToken   = env("API_TOKEN");

        if ($providedToken == $storedToken) {
            return $next($request);
        }

        return response()->json('Invalid Token', 401);
    }
}
