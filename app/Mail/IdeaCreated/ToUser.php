<?php

namespace App\Mail\IdeaCreated;

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
            ->subject('Добавлена новая идея.')
            ->view('emails.idea-created.to-user', ['idea' => $this->idea]);
    }
}
