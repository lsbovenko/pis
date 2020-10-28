<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasCreated;
use App\Mail\IdeaCreated\ToUser;
use App\Mail\IdeaCreated\ToSuperadmin;
use App\Repositories\User as UserRepo;

/**
 * Class IdeaCreated
 *
 * @package App\Handlers\Events
 */
class IdeaCreated extends AbstractIdea
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param IdeaWasCreated $event
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
        if (!empty($user) && $user->is_active == 1) {
            $this->getQueueService()->add($user->email, new ToUser($event->getIdea()));
        }

        return $this;
    }

    /**
     * @param IdeaWasCreated $event
     * @return $this
     */
    protected function notifySuperadmins(IdeaWasCreated $event)
    {
        foreach ($this->userRepo->getSuperadmins() as $user) {
            $this->getQueueService()->add($user['email'], new ToSuperadmin($event->getIdea()));
        }
        return $this;
    }
}
