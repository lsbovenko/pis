<?php

namespace App\Mail\IdeaExecutorsRemoved;

use App\Mail\AbstractMail;

/**
 * Class ToAllExecutors
 *
 * @package App\Mail\IdeaExecutorsRemoved
 */
class ToAllExecutors extends AbstractMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('От вас откреплена реализация предложения №' . $this->idea->id)
            ->view('emails.idea-executors-removed.to-all-executors', ['idea' => $this->idea]);
    }
}
