<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\IdeaApproved\{
    ToUser,
    ToAdmin
};
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
        $this
            ->notifyUser($event)
            ->notifyAdmins($event);
    }

    /**
     * @param IdeaWasApproved $event
     * @return $this
     */
    protected function notifyUser(IdeaWasApproved $event)
    {
        $user = $event->getIdea()->user()->first();
        if ($user->is_active == 1) {
            $user->notify(new ToUser($event->getIdea()));
        }

        return $this;
    }

    /**
     * @param IdeaWasApproved $event
     * @return $this
     */
    protected function notifyAdmins(IdeaWasApproved $event)
    {
        foreach ($this->getRemoteUserRepository()->getAdmins() as $user) {
            $user = $this->createUserModel($user);
            $user->notify(new ToAdmin($event->getIdea()));
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
