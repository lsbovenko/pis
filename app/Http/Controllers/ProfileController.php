<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var \App\Models\Auth\User $user */
        $user = Auth::user();
        $rulesValidation = [
            'name' => 'required|max:255',
            'email' => 'required|email'
        ];

        if ($request->input('email') !== $user->email) {
            $rulesValidation['email'] = 'required|email|unique:users,email';
        }
        $this->validate($request, $rulesValidation);
        $input = $request->all();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();
        $request->session()->flash('alert-success', 'Изменения успешно сохранены.');

        return redirect()->route('profile.index');
    }

    /**
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePass(PasswordRequest $request)
    {
        /** @var \App\Models\Auth\User $user */
        $user = Auth::user();
        $input = $request->all();
        $user->password = bcrypt($input['password']);
        $user->save();
        $request->session()->flash('alert-success', 'Пароль успешно изменен.');

        return redirect()->route('profile.index');
    }
}
