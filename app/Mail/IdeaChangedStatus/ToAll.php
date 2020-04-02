<?php

namespace App\Mail\IdeaChangedStatus;

use App\Mail\AbstractMail;

/**
 * Class ToUser
 *
 * @package App\Mail\IdeaChangedStatus
 */
class ToAll extends AbstractMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Реализована очередная идея PIS.')
            ->view(
                'emails.idea-changed-status.to-all',
                [
                'idea' => $this->idea,
                ]
            );
    }
}
