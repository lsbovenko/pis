<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\User\{
    RegistrationRequest,
    UpdateRequest
};
use App\Models\Auth\User;
use App\Service\Reference;
use Illuminate\Support\Facades\{
    App,
    DB
};
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
        $input = App::make('datacleaner')->cleanData($request->all());
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

        $input = App::make('datacleaner')->cleanData($request->all());
        if ($input['email'] !== $user->email) {
            $rulesValidation['email'] = 'required|email|unique:users,email';
            $this->validate($request, $rulesValidation);
        }

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
     * @param Reference $reference
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Reference $reference)
    {
        /** @var \App\Models\Auth\User $user */
        $user = User::findOrFail($request->route('id'));

        return view('users.edit', [
            'user' => $user,
            'inviteStatus' => $user->invitations()->first()->status,
            'roles' => $reference->getAllRolesForSelect(),
            'departments' => $reference->getAllDepartmentForSelect(),
            'positions' => $reference->getAllPositionsForSelect(),
        ]);
    }

    /**
     * @param Reference $reference
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Reference $reference)
    {
        return view('users.create', [
            'roles' => $reference->getAllRolesForSelect(),
            'departments' => $reference->getAllDepartmentForSelect(),
            'positions' => $reference->getAllPositionsForSelect(),
        ]);
    }
}
