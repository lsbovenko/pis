<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 22.01.19
 * Time: 11:49
 */

namespace App\Handlers\Events;

use App\Events\LikeAdded;
use App\Mail\IdeaLikeNotify\ToUser;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;

class IdeaLikeNotification extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  LikeAdded $event
     * @return void
     */
    public function handle(LikeAdded $event)
    {
        $likeAuthor = $this->getLikeAuthor($event);
        $ideaAuthor = $this->getIdeaAuthor($event);
        $superAdmins = $this->getSuperAdmins();
        $executors = $this->getExecutors($event);

        $users = $ideaAuthor->merge($superAdmins)->merge($executors)->diff($likeAuthor);

        $this->notifyUsers($event, $users);
    }

    protected function getLikeAuthor(LikeAdded $event)
    {
        $collection = new Collection();
        $likeAuthor = $event->getLikeAuthor();

        return $collection->push($likeAuthor);
    }

    protected function getIdeaAuthor(LikeAdded $event)
    {
        $ideaAuthorId = $event->getIdea()->user_id;

        return User::where('id', $ideaAuthorId)->where('is_active', 1)->get();
    }

    protected function getSuperAdmins()
    {
        return App::make('repository.user')->getSuperadmins();
    }

    protected function getExecutors(LikeAdded $event)
    {
        return $event->getIdea()->executors->where('is_active', 1);
    }

    protected function notifyUsers(LikeAdded $event, Collection $users)
    {
        foreach ($users as $user) {
            $this->getQueueService()->add($user->email, new ToUser($event->getIdea(), $event->getLikeAuthor()));
        }
    }
}
