<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 17.01.19
 * Time: 13:30
 */

namespace App\Handlers\Events;

use App\Events\CommentAdded;
use App\Mail\IdeaComment\ToAll;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;

class IdeaComment extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  CommentAdded $event
     * @return void
     */
    public function handle(CommentAdded $event)
    {
        $this->notifyIdeaAuthor($event);
    }

    /**
     * @param CommentAdded $event
     * @return $this
     */
    protected function notifyIdeaAuthor(CommentAdded $event)
    {
        $ideaAuthor = $event->getComment()->idea()->first()->user;
        $commentAuthor = $event->getComment()->user()->first();

        if ($ideaAuthor->is_active == 1 && $ideaAuthor->id !== $commentAuthor->id) {
            $this->getQueueService()->add($ideaAuthor->email, new ToAll($event->getComment()));
        }

        return $this;
    }
}