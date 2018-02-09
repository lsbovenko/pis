<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasCreated;
use App\Mail\IdeaCreated\{
    ToUser,
    ToSuperadmin
};

/**
 * Class IdeaCreated
 * @package App\Handlers\Events
 */
class IdeaCreated extends AbstractIdea
{
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
        if ($user->is_active == 1) {
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
        foreach ($this->getRemoteUserRepository()->getSuperadmins() as $user) {
            $this->getQueueService()->add($user['email'], new ToSuperadmin($event->getIdea()));
        }
        return $this;
    }
}
