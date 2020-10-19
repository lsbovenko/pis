<?php

namespace App\Http\Middleware;

use App\Libraries\OpenIDConnectClient;
use Illuminate\Support\Facades\Auth;

/**
 * Class VelmieOIDCAuth
 *
 * @package App\Http\Middleware
 */
class VelmieOIDCAuth
{
    protected $authApiClient;

    public function __construct(OpenIDConnectClient $authApiClient)
    {
        $this->authApiClient = $authApiClient;
    }

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
            return redirect()->guest($this->authApiClient->getAuthorizationUrlAndCommit());
        }

        return $next($request);
    }
}
