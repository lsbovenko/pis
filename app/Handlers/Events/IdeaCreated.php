<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\IdeaCreated\{
    ToUser,
    ToSuperadmin
};
use App\Models\Auth\User;
use Illuminate\Support\Facades\App;

/**
 * Class IdeaCreated
 * @package App\Handlers\Events
 */
class IdeaCreated
{
    /**
     * @var \App\Repositories\User
     */
    protected $userRepository;

    /**
     * Handle the event.
     *
     * @param  IdeaCreated $event
     * @return void
     */
    public function handle(IdeaWasCreated $event)
    {
        $this
            ->notifyUser($event)
            ->notifySuperadmins($event);
    }

    /**
     * @param IdeaWasCreated $event
     * @return $this
     */
    protected function notifyUser(IdeaWasCreated $event)
    {
        $user = $event->getIdea()->user()->first();
        if ($user->is_active == 1) {
            $user->notify(new ToUser($event->getIdea()));
        }

        return $this;
    }

    /**
     * @param IdeaWasCreated $event
     * @return $this
     */
    protected function notifySuperadmins(IdeaWasCreated $event)
    {
        foreach ($this->getRemoteUserRepository()->getSuperadmins() as $user) {
            $user = $this->createUserModel($user);
            $user->notify(new ToSuperadmin($event->getIdea()));
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
