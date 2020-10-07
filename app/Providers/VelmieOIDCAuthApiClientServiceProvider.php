<?php

namespace App\Providers;

use App\Libraries\OpenIDConnectClient;
use Illuminate\Support\ServiceProvider;

/**
 * Class VelmieOIDCAuthApiClientServiceProvider
 *
 * @package App\Providers
 */
class VelmieOIDCAuthApiClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OpenIDConnectClient::class, function($app) {
            $OIDCClient = new OpenIDConnectClient(
                config('oidc.url'),
                config('oidc.client_id'),
                config('oidc.client_secret')
            );

            $OIDCClient->setRedirectURL(config('oidc.redirect_url'));
            $OIDCClient->addScope(['openid', 'all']);

            return $OIDCClient;
        });
    }
}
