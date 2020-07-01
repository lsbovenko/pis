<?php

namespace App\Handlers\Events;

use App\Events\CommentLikeAdded;
use App\Mail\CommentLikeNotification\ToExecutorsAndCommentAuthor;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class IdeaCommentLike extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  CommentLikeAdded $event
     * @return void
     */
    public function handle(CommentLikeAdded $event)
    {
        $commentAuthor = $this->getCommentAuthor($event);
        $executors = $this->getExecutors($event);
        $commentLikeAuthor = $this->getCommentLikeAuthor();
        $superAdmins = $this->getSuperAdmins();

        $users = $commentAuthor->merge($superAdmins)->merge($executors)->diff($commentLikeAuthor);

        $this->notifyUsers($event, $users);
    }

    protected function getSuperAdmins()
    {
        return App::make('repository.user')->getSuperadmins();
    }

    protected function getCommentLikeAuthor()
    {
        $commentLikeAuthorId = Auth::user()->id;

        return User::where('id', $commentLikeAuthorId)->get();
    }

    protected function getCommentAuthor(CommentLikeAdded $event)
    {
        $commentAuthorId = $event->getComment()->user_id;

        return User::where('id', $commentAuthorId)->get();
    }

    protected function getExecutors(CommentLikeAdded $event)
    {
        return $event->getComment()->idea->executors->where('is_active', 1);
    }

    protected function notifyUsers(CommentLikeAdded $event, Collection $users)
    {
        foreach ($users as $user) {
            $this->getQueueService()->add($user->email, new ToExecutorsAndCommentAuthor($event->getComment()));
        }
    }
}
