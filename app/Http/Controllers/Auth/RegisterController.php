<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Junaidnasir\Larainvite\Facades\Invite;

use Illuminate\Http\Request;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
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

        //todo
        //$this->guard()->login($user);

        return redirect()->route('main');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
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
