<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jumbojett\OpenIDConnectClient;

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
    public function handle(Request $request, \Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isActive() || $this->isSessionLifetimeUp($request)) {
            return redirect()->guest($this->authApiClient->getAuthorizationUrlAndCommit());
        }

        return $next($request);
    }

    private function isSessionLifetimeUp(Request $request)
    {
        $session = $request->session();

        $now = Carbon::now()->timestamp;
        $startSession = $session->get('oidc_auth_time', null);
        if ($startSession === null) {
            return false;
        }

        return $now - $startSession > config('oidc.session_lifetime') * Carbon::SECONDS_PER_MINUTE;
    }
}
