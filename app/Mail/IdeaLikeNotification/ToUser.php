<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 18.01.19
 * Time: 11:29
 */

namespace App\Mail\IdeaLikeNotify;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Idea;

class ToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Idea
     */
    protected $idea;
    /**
     * @var User
     */
    private $likeAuthor;

    /**
     * ToUser constructor.
     * @param Idea $idea
     * @param User $likeAuthor
     */
    public function __construct(Idea $idea, User $likeAuthor)
    {
        $this->idea = $idea;
        $this->likeAuthor = $likeAuthor;
    }

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
                'idea' => $this->idea,
                'likeAuthor' => $this->likeAuthor,
            ]);
    }
}