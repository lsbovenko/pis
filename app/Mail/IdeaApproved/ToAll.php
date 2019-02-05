<?php

namespace App\Mail\IdeaApproved;

use App\Mail\AbstractMail;

/**
 * Class ToUser
 * @package App\Mail\IdeaApproved
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
            ->subject('Добавлена новая идея в PIS')
            ->view('emails.idea-approved.to-all', ['idea' => $this->idea]);
    }
}
