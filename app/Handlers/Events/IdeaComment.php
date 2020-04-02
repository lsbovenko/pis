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
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Collection;

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
        $commentAuthor = $this->getCommentAuthor($event);
        $ideaAuthor = $this->getIdeaAuthor($event);
        $superAdmins = $this->getSuperAdmins();
        $executors = $this->getExecutors($event);

        $users = $ideaAuthor->merge($superAdmins)->merge($executors)->diff($commentAuthor);

        $this->notifyUsers($event, $users);
    }

    protected function getCommentAuthor(CommentAdded $event)
    {
        $commentAuthorId = $event->getComment()->user_id;

        return User::where('id', $commentAuthorId)->get();
    }

    protected function getIdeaAuthor(CommentAdded $event)
    {
        $ideaAuthorId = $event->getComment()->idea->user_id;

        return User::where('id', $ideaAuthorId)->where('is_active', 1)->get();
    }

    protected function getSuperAdmins()
    {
        return App::make('repository.user')->getSuperadmins();
    }

    protected function getExecutors(CommentAdded $event)
    {
        return $event->getComment()->idea->executors->where('is_active', 1);
    }

    protected function notifyUsers(CommentAdded $event, Collection $users)
    {
        foreach ($users as $user) {
            $this->getQueueService()->add($user->email, new ToAll($event->getComment()));
        }
    }
}
