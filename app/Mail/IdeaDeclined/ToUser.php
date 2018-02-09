<?php

namespace App\Mail\IdeaDeclined;

use App\Mail\AbstractMail;

/**
 * Class ToUser
 * @package App\Mail\IdeaCreated
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
            ->subject('Идея отклонена.')
            ->view('emails.idea-declined.to-user', [
                'idea' => $this->idea,
                'reason' => $this->idea->getDeclineReason(),
            ]);
    }
}
