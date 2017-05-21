<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth\Role;
use App\Models\Categories\Department;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = '';
        return view('users.index', ['users' => $users]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View\
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'department' => [
                Rule::in(array_keys($this->getDepartments())),
                'required',
            ],
            'role' => [
                Rule::in(array_keys($this->getRoles())),
                'required',
            ],
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            'roles' => $this->getRoles(),
            'departments' => $this->getDepartments(),
        ]);
    }

    protected function getRoles()
    {
        $res = [];
        foreach (Role::orderBy('id', 'desc')->get() as $role)
        {
            $res[$role->id] = $role->display_name;
        }

        return $res;
    }

    protected function getDepartments()
    {
        $res = [];
        foreach (Department::orderBy('id')->get() as $department)
        {
            $res[$department->id] = $department->name;
        }

        return $res;
    }
}
