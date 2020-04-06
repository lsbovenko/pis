<?php

/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 17.01.19
 * Time: 16:44
 */

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractComment extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var $comment
     */
    protected $comment;

    /**
     * ToAll constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
