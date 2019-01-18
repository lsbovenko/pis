<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 18.01.19
 * Time: 11:29
 */

namespace App\Mail\IdeaLikeNotify;


use App\Mail\AbstractMail;

class ToUser extends AbstractMail
{
    /**
     * Build the message.
     *
     * @return ToUser
     */
    public function build()
    {
        return $this
            ->subject('Ваша идея понравилась в PIS')
            ->view('emails.like.to-user', [
                'idea' => $this->idea
            ]);
    }
}