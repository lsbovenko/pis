<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

/**
 * Class VelmieOIDCAuth
 *
 * @package App\Http\Middleware
 */
class VelmieOIDCAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isActive()) {
            return redirect()->guest(route('auth'));
        }

        return $next($request);
    }
}
