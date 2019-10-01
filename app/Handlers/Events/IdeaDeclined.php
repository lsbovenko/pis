<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasDeclined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\IdeaDeclined\ToUser;

/**
 * Class IdeaDeclined
 * @package App\Handlers\Events
 */
class IdeaDeclined extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  IdeaWasDeclined  $event
     * @return void
     */
    public function handle(IdeaWasDeclined $event)
    {
        $this->notifyUser($event);
    }

    /**
     * @param IdeaWasDeclined $event
     * @return $this
     */
    protected function notifyUser(IdeaWasDeclined $event)
    {
        $user = $event->getIdea()->user()->first();
        if (!empty($user) && $user->is_active == 1) {
            $this->getQueueService()->add($user->email, new ToUser($event->getIdea()));
        }

        return $this;
    }
}
