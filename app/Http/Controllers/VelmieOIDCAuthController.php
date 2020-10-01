<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class VelmieOIDCAuthController
 *
 * @package App\Http\Controllers
 */
class VelmieOIDCAuthController extends Controller
{
    public function callback(Request $request)
    {
        $userParams = $request->all();
        if (empty($userParams['external_id'])) {
            return redirect()->guest(config('app.auth_url'));
        }
        $query = User::where('external_id', $userParams['external_id']);
        if ($query->first()) {
            $query->update($userParams);
        } else {
            $userParams['is_active'] = 1;
            User::create($userParams);
        }
        Auth::login($query->first());

        return redirect()->intended();
    }
}
