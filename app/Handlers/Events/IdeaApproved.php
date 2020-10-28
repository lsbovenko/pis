<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasApproved;
use App\Mail\IdeaApproved\ToAll;
use App\Repositories\User as UserRepo;

/**
 * Class IdeaApproved
 *
 * @package App\Handlers\Events
 */
class IdeaApproved extends AbstractIdea
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

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
        foreach ($this->userRepo->getActiveUsers() as $user) {
            $this->getQueueService()->add($user['email'], new ToAll($event->getIdea()));
        }

        return $this;
    }
}
