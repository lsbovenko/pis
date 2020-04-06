<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 17.01.19
 * Time: 13:32
 */

namespace App\Mail\IdeaComment;

use App\Mail\AbstractComment;

class ToAll extends AbstractComment
{
    /**
     * Build the message.
     *
     * @return ToAll
     */
    public function build()
    {
        return $this
            ->subject('Добавлен новый комментарий в PIS')
            ->view(
                'emails.comments.to-all',
                [
                'comment' => $this->comment
                ]
            );
    }
}
