<?php

namespace App\Mail\IdeaCreated;

use App\Mail\AbstractMail;

/**
 * Class ToSuperadmin
 *
 * @package App\Mail\IdeaCreated
 */
class ToSuperadmin extends AbstractMail
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
            ->view('emails.idea-created.to-superadmin', ['idea' => $this->idea]);
    }
}
