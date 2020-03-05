<?php

namespace App\Service;

use App\Models\Auth\User;
use Illuminate\Encryption\Encrypter;

class Webhook
{
    protected $encrypter;

    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    public function receive(string $data)
    {
        $userData = $this->encrypter->decrypt($data);

        $user = User::where('email', $userData['email'])->first();

        if ($user) {
            foreach ($user->getSyncItems() as $attribute) {
                if (isset($userData[$attribute])) {
                    $user->{$attribute} = $userData[$attribute];
                }
            }
            $user->save();
        }
    }
}
