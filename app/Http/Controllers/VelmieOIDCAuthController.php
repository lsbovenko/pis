<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use App\Service\UserSyncService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function callback(Request $request, OpenIDConnectClient $authApiClient, UserSyncService $userSyncService)
    {
        $authApiClient->authenticate();
        $userData = $authApiClient->getVerifiedClaims('data');
        $userSyncService->sync([$userData]);

        $user = User::where('external_id', $userData->externalId)->first();
        Auth::login($user);
        $startSession = Carbon::now()->timestamp;
        $request->session()->put('oidc_auth_time', $startSession);

        return redirect()->intended();
    }
}
