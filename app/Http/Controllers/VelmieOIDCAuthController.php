<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Jumbojett\OpenIDConnectClient;

/**
 * Class VelmieOIDCAuthController
 *
 * @package App\Http\Controllers
 */
class VelmieOIDCAuthController extends Controller
{
    public function callback(OpenIDConnectClient $authApiClient)
    {
        $authApiClient->authenticate();
        $verifiedClaims = $authApiClient->getVerifiedClaims('data');

        $userParams = [
            'name' => $verifiedClaims->firstName,
            'last_name' => $verifiedClaims->lastName,
            'email' => $verifiedClaims->email,
            'is_active' => (int)$verifiedClaims->active,
            'avatar' => $verifiedClaims->avatar->small,
            'external_id' => $verifiedClaims->externalId,
        ];

        if (empty($userParams['external_id'])) {
            return redirect()->guest(config('app.auth_url'));
        }

        $departmentRepository = App::make('repository.department');
        $userParams['department_id'] = $departmentRepository->getDepartmentByName($verifiedClaims->department)->id;

        $positionRepository = App::make('repository.position');
        $userParams['position_id'] = $positionRepository->getPositionByName($verifiedClaims->position)->id;

        $user = User::where('external_id', $userParams['external_id'])->first();
        $user ? $user->update($userParams) : $user = User::create($userParams);

        $roleRepository = App::make('repository.role');
        $roleRepository->updateRole($user, $verifiedClaims->roles);

        Auth::login($user);

        return redirect()->intended();
    }
}
