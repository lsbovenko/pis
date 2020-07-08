<?php

namespace App\Mail\CommentLikeNotification;

use App\Mail\AbstractComment;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ToExecutorsAndCommentAuthor extends AbstractComment
{
    private $likeAuthor;

    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
        $this->likeAuthor = Auth::user()->name . " " . Auth::user()->last_name;
    }

    public function getLikeAuthor()
    {
        return $this->likeAuthor;
    }

    /**
     * Build the message.
     *
     * @return ToExecutorsAndCommentAuthor
     */
    public function build()
    {
        return $this
            ->subject('Добавлен лайк к комментарию в PIS')
            ->view(
                'emails.comment-like.to-executors-and-comment-author',
                [
                'comment' => $this->comment,
                'likeAuthor' => $this->getLikeAuthor()
                ]
            );
    }
}
