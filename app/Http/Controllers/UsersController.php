<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\User\{
    RegistrationRequest,
    UpdateRequest
};

use App\Models\Auth\User;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index', ['users' => User::where('id', '>', 0)->paginate(15)]);
    }

    /**
     * @param RegistrationRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function saveNew(RegistrationRequest $request)
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
            $user->notify(new \App\Notifications\SendInvite($refCode));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('users.index');
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        /** @var \App\Models\Auth\User $user */
        $user = User::findOrFail($request->route('id'));
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? (int)$input['is_active'] : 0;
        $user->fill($input);
        $role = \App\Models\Auth\Role::findOrFail($input['role_id']);
        $user->save();
        $user->detachRole($user->roles()->first());
        $user->attachRole($role);

        return redirect()->route('users.index');
    }

    /**
     * @param Request $request
     * @param DepartmentRepository $departmentRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, DepartmentRepository $departmentRepository, RoleRepository $roleRepository)
    {
        /** @var \App\Models\Auth\User $user */
        $user = User::findOrFail($request->route('id'));

        return view('users.edit', [
            'user' => $user,
            'inviteStatus' => $user->invitations()->first()->status,
            'roles' => $roleRepository->getAllForSelect(),
            'departments' => $departmentRepository->getAllForSelect(),
        ]);
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
