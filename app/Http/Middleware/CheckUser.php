<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\User;

/**
 * Class CheckUser
 * @package App\Http\Middleware
 */
class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((int)($request->session()->get('jwt_check_user_time')) < time()) {
            $this->check($request->user());
            $request->session()->put('jwt_check_user_time', time() + config('jwt.time_check_user') * 60);
        }

        return $next($request);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function check(User $user)
    {

        $remoteUser = App::make('auth.api.client')->getUser($user->email);

        dd($remoteUser);

        if (!$user->isActive) {
            Auth::logout();
            return redirect(config('app.auth_url'));
        }
    }
}
