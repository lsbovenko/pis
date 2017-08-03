<?php

namespace App\Service;

/**
 * Class AuthApiClient
 * @package App\Service
 */
class AuthApiClient
{

    public function getUser(string $email)
    {
        $url = $this->getApiUrl() . 'users/' . $email;


        return $user;
    }

    public function getUsers(array $conditions = [])
    {
        $url = $this->getApiUrl() . 'users';



        return $users;
    }




    public function getApiUrl(): string
    {
        return config('app.auth_url') . '/api/v1/';
    }
}