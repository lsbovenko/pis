<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jumbojett\OpenIDConnectClient;

/**
 * Class VelmieOIDCAuthApiClientServiceProvider
 *
 * @package App\Providers
 */
class VelmieOIDCAuthApiClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OpenIDConnectClient::class, function ($app) {
            $OIDCClient = new OpenIDConnectClient(
                config('oidc.url'),
                config('oidc.client_id'),
                config('oidc.client_secret')
            );

            $OIDCClient->setRedirectURL(route('auth'));
            $OIDCClient->addScope(['openid', 'all']);

            return $OIDCClient;
        });
    }
}
