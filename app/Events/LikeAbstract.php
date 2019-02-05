<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 18.01.19
 * Time: 12:32
 */

namespace App\Events;

use App\Models\Auth\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Idea;

abstract class LikeAbstract
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Idea
     */
    protected $idea;
    /**
     * @var User
     */
    protected $likeAuthor;

    /**
     * LikeAbstract constructor.
     * @param Idea $idea
     * @param User $likeAuthor
     */
    public function __construct(Idea $idea, User $likeAuthor)
    {
        $this->idea = $idea;
        $this->likeAuthor = $likeAuthor;
    }

    /**
     * @return Idea
     */
    public function getIdea() : Idea
    {
        return $this->idea;
    }

    /**
     * @return User
     */
    public function getLikeAuthor()
    {
        return $this->likeAuthor;
    }
}