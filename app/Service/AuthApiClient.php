<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Mockery\Exception;

/**
 * Class AuthApiClient
 * @package App\Service
 */
class AuthApiClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * AuthApiClient constructor.
     * @param Client $httpClient
     */
    function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->setApiKey();
    }

    public function getUser(string $email)
    {
        $endpoint = 'users/' . $email;

        try {
            $response = $this->sendRequest($endpoint, 'GET');
            if ($response->getStatusCode() == 200) {
                $user = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            }
        } catch (\Exception $e) {
            throw new \Exception('Error code ' . $e->getCode());
        }

        return $user ?? false;
    }

    public function getUsers(array $query = [])
    {
        $endpoint = 'users';

        $query = [
            'conditions' => [
                [
                    'field' => 'role',
                    'condition' => '=',
                    'value' => 'admin'
                ],
                [
                    'field' => 'created_at',
                    'condition' => '<',
                    'value' => time(),
                ],
                [
                    'field' => 'is_active',
                    'condition' => '=',
                    'value' => '1'
                ],
            ],
        ];


        /*$this->httpClient->request('GET', 'http://httpbin.org', [
            'query' => $query
        ]);*/

        //$response = $this->sendRequest($endpoint, 'GET', $query);
        $options = ['query' => $query];

        $response = $this->sendRequest($endpoint, 'GET', $options);

        return $users;
    }


    protected function sendRequest(string $endpoint, string $method, array $options = [])
    {
        $url = $this->getApiUrl() . $endpoint;
        $options['headers'] = $this->getRequestHeaders();
        return $this->httpClient->request($method, $url, $options);

        //return $this->httpClient->send($this->createRequest($method, $url, $query));
    }


    /*protected function createRequest($method, $url, array $query = [])
    {
        $url = $this->buildUrl($url, $query);

        return new Request($method, $url, $this->getRequestHeaders());
    }

    protected function buildUrl(string $url, array $query = [])
    {
        if (!empty($query)) {



        }

        return $url;
    }*/

    /**
     * @return array
     */
    protected function getRequestHeaders(): array
    {
        return [
            'X-Ikantam-API-Key' => $this->apiKey
        ];
    }

    /**
     * @return $this
     */
    protected function setApiKey()
    {
        $apiKey = config('app.auth_api_key');
        if (!$apiKey) {
            throw new \Exception('auth_api_key not found');
        }

        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
     */
    protected function getApiUrl(): string
    {
        return config('app.auth_url') . '/api/v1/';
    }
}