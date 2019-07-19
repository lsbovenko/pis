<?php

namespace App\Handlers\Events;

use App\Events\IdeaExecutorsWasRemoved;
use App\Mail\IdeaExecutorsRemoved\ToAllExecutors;

/**
 * Class IdeaExecutorsRemoved
 * @package App\Handlers\Events
 */
class IdeaExecutorsRemoved extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  IdeaExecutorsWasRemoved $event
     * @return void
     */
    public function handle(IdeaExecutorsWasRemoved $event)
    {
        $this->notifyAll($event);
    }

    /**
     * @param IdeaExecutorsWasRemoved $event
     * @return $this
     */
    protected function notifyAll(IdeaExecutorsWasRemoved $event)
    {
        foreach ($event->getExecutors() as $executor) {
            $this->getQueueService()->add($executor->email, new ToAllExecutors($event->getIdea()));
        }

        return $this;
    }
}
