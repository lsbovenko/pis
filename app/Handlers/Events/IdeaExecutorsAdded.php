<?php

namespace App\Handlers\Events;

use App\Events\IdeaExecutorsWasAdded;
use App\Mail\IdeaExecutorsAdded\ToAllExecutors;

/**
 * Class IdeaExecutorsAdded
 *
 * @package App\Handlers\Events
 */
class IdeaExecutorsAdded extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  IdeaExecutorsWasAdded $event
     * @return void
     */
    public function handle(IdeaExecutorsWasAdded $event)
    {
        $this->notifyAll($event);
    }

    /**
     * @param IdeaExecutorsWasAdded $event
     * @return $this
     */
    protected function notifyAll(IdeaExecutorsWasAdded $event)
    {
        foreach ($event->getExecutors() as $executor) {
            $this->getQueueService()->add($executor->email, new ToAllExecutors($event->getIdea()));
        }

        return $this;
    }
}
