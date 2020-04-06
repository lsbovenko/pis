<?php

namespace App\Mail\IdeaExecutorsAdded;

use App\Mail\AbstractMail;

/**
 * Class ToAllExecutors
 *
 * @package App\Mail\IdeaExecutorsAdded
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
            ->subject('За вами закреплена реализация предложения №' . $this->idea->id)
            ->view('emails.idea-executors-added.to-all-executors', ['idea' => $this->idea]);
    }
}
