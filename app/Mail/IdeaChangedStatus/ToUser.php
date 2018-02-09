<?php

namespace App\Mail\IdeaChangedStatus;

use App\Mail\AbstractMail;

/**
 * Class ToUser
 * @package App\Mail\IdeaChangedStatus
 */
class ToUser extends AbstractMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Изменен статус идеи.')
            ->view('emails.idea-changed-status.to-user', [
                'idea' => $this->idea,
                'status' => $this->idea->status()->first(),
            ]);
    }
}
