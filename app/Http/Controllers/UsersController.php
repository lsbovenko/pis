<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index', ['users' => User::where('id', '>', 0)->paginate(15)]);
    }
}
