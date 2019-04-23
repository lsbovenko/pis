<?php

namespace App\Service;

use App\Models\EmailQueue;
use Illuminate\Mail\Mailable;
use Carbon\Carbon;

/**
 * Class EmailQueueCreator
 * @package App\Service
 */
class EmailQueueCreator
{
    /**
     * @param string|array $email
     * @param Mailable $message
     */
    public function add($email, Mailable $message)
    {
        if (is_array($email)) {
            $payload = serialize($message);
            $date = Carbon::now()->format('Y-m-d H:i:s');
            foreach ($email as $currentEmail) {
                $emailQueueArray[] = [
                    'email' => $currentEmail,
                    'payload' => $payload,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
            if (isset($emailQueueArray)) {
                EmailQueue::insert($emailQueueArray);
            }
        } else {
            EmailQueue::create([
                'email' => $email,
                'payload' => serialize($message),
            ]);
        }
    }
}
