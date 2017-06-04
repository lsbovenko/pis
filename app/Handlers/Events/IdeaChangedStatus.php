<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasChangedStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Notifications\IdeaChangedStatus\ToUser;

class IdeaChangedStatus
{
    /**
     * Handle the event.
     *
     * @param  IdeaCreated  $event
     * @return void
     */
    public function handle(IdeaWasChangedStatus $event)
    {
        $this->notifyUser($event);
    }

    /**
     * @param IdeaWasChangedStatus $event
     * @return $this
     */
    protected function notifyUser(IdeaWasChangedStatus $event)
    {
        $event->getIdea()->user()->first()->notify(new ToUser($event->getIdea()));

        return $this;
    }
}
