<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Repositories\{
    Department as DepartmentRepository,
    Role as RoleRepository
};

use Illuminate\Support\Facades\DB;
use Junaidnasir\Larainvite\Facades\Invite;

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
     * @param UserRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function saveNew(UserRequest $request)
    {
        $input = $request->all();
        $user = (new \App\Models\Auth\User($input));
        $user->is_active = 1;
        DB::beginTransaction();
        try {
            $role = \App\Models\Auth\Role::findOrFail($input['role_id']);
            $user->save();
            $user->attachRole($role);

            $refCode = Invite::invite($user->email, $user->id);

            //todo send email

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('users.index');
    }

    public function update(UserRequest $request)
    {




        return redirect('index');
    }

    /**
     * @param DepartmentRepository $departmentRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(DepartmentRepository $departmentRepository, RoleRepository $roleRepository)
    {
        return view('users.create', [
            'roles' => $roleRepository->getAllForSelect(),
            'departments' => $departmentRepository->getAllForSelect(),
        ]);
    }
}
