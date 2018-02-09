<?php

namespace App\Service;

use App\Models\EmailQueue;
use Illuminate\Mail\Mailable;

/**
 * Class EmailQueueCreator
 * @package App\Service
 */
class EmailQueueCreator
{
    /**
     * @param string $email
     * @param Mailable $message
     */
    public function add(string $email, Mailable $message)
    {
        EmailQueue::create([
            'email' => $email,
            'payload' => serialize($message),
        ]);
    }
}
