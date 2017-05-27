<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Junaidnasir\Larainvite\Facades\Invite;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\User\PasswordRequest;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        $code = $request->route('code');
        try {
            if(!Invite::isValid($code)) {
                abort(404);
            }
        } catch (\Exception $e) {
            abort(404);
        }

        return view('auth.register', ['code' => $code]);
    }

    /**
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(PasswordRequest $request)
    {
        $code = $request->route('code');
        try {
            if(Invite::isValid($code)){
                $invitation = Invite::get($code);
                $user = $invitation->user;
                $data = $request->all();
                $user->password = bcrypt($data['password']);
                $user->save();
                Invite::consume($code);
            }
        } catch (\Exception $e) {
            abort(404);
        }

        $this->guard()->login($user);

        return redirect()->route('main');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
