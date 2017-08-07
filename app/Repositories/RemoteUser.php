<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;

/**
 * Class RemoteUser
 * @package App\Repositories
 */
class RemoteUser
{
    /**
     * @return []
     */
    public function getSuperadmins()
    {
        $query = [
            'criteria' => [
                [
                    'field' => 'role',
                    'condition' => '=',
                    'value' => 'pis_superadmin'
                ],
                [
                    'field' => 'is_active',
                    'condition' => '=',
                    'value' => '1'
                ],
            ],
        ];

        return $this->getAuthApiClient()->getUsers($query);
    }

    /**
     * @return []
     */
    public function getAdmins()
    {
        $query = [
            'criteria' => [
                [
                    'field' => 'role',
                    'condition' => '=',
                    'value' => 'pis_admin'
                ],
                [
                    'field' => 'is_active',
                    'condition' => '=',
                    'value' => '1'
                ],
            ],
        ];

        return $this->getAuthApiClient()->getUsers($query);
    }


    /**
     * @return \App\Service\AuthApiClient
     */
    protected function getAuthApiClient()
    {
        return App::make('auth.api.client');
    }
}