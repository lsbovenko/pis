<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\IdeaApproved\ToAll;
use Illuminate\Support\Facades\App;
use App\Models\Auth\User;

/**
 * Class IdeaApproved
 * @package App\Handlers\Events
 */
class IdeaApproved
{
    /**
     * @var \App\Repositories\User
     */
    protected $userRepository;

    /**
     * Handle the event.
     *
     * @param  IdeaWasApproved $event
     * @return void
     */
    public function handle(IdeaWasApproved $event)
    {
        $this->notifyAll($event);
    }

    /**
     * @param IdeaWasApproved $event
     * @return $this
     */
    protected function notifyAll(IdeaWasApproved $event)
    {
        foreach ($this->getRemoteUserRepository()->getAll() as $user) {
            $user = $this->createUserModel($user);
            $user->notify(new ToAll($event->getIdea()));
        }

        return $this;
    }

    /**
     * a user may not exist in our database, so we create a temporary object
     * do not save this model!!!!!!!!!!!!!
     * @param array $user
     * @return User
     */
    protected function createUserModel(array $user)
    {
        return new User($user);
    }


    /**
     * @return \App\Repositories\RemoteUser
     */
    protected function getRemoteUserRepository(): \App\Repositories\RemoteUser
    {
        return App::make('repository.remote_user');
    }
}
