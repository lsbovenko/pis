<?php

namespace App\Service;

class AuthV2ApiClient
{
    protected $httpClient;

    public function __construct()
    {
        $headers = [
            'Authorization' => 'Bearer ' . config('app.api_token'),
            'Accept' => 'application/json',
        ];

        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => config('app.auth_url') . '/api/v2/',
            'headers' => $headers,
            'timeout' => 10.0,
        ]);
    }

    public function getActiveUsers()
    {
        $response = $this->httpClient->request('GET', 'users/active');
        $data = json_decode($response->getBody()->getContents());

        return $data->data;
    }
}
