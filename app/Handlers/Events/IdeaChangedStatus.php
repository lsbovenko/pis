<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasChangedStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Categories\Status;
use App\Mail\IdeaChangedStatus\ToUser;
use App\Mail\IdeaChangedStatus\ToAll;

use Illuminate\Support\Facades\App;

/**
 * Class IdeaChangedStatus
 *
 * @package App\Handlers\Events
 */
class IdeaChangedStatus extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  IdeaWasChangedStatus $event
     * @return void
     */
    public function handle(IdeaWasChangedStatus $event)
    {
        if ($event->getIdea()->status->slug == Status::SLUG_COMPLETED) {
            $this->notifyAll($event);
        } else {
            $this->notifyUser($event);
        }
        $this->unpinPriority($event);
    }

    /**
     * @param IdeaWasChangedStatus $event
     * @return $this
     */
    protected function notifyUser(IdeaWasChangedStatus $event)
    {
        $user = $event->getIdea()->user()->first();
        if (!empty($user) && $user->is_active == 1) {
            $this->getQueueService()->add($user->email, new ToUser($event->getIdea()));
        }

        return $this;
    }

    protected function notifyAll(IdeaWasChangedStatus $event)
    {
        foreach ($this->getRemoteUserRepository()->getAll() as $user) {
            $this->getQueueService()->add($user['email'], new ToAll($event->getIdea()));
        }

        return $this;
    }

    /**
     * @param IdeaWasChangedStatus $event
     * @return $this
     */
    protected function unpinPriority(IdeaWasChangedStatus $event)
    {
        $idea = $event->getIdea();
        $statuses = [
            App::make('repository.status')->getBySlug(Status::SLUG_COMPLETED)->id,
            App::make('repository.status')->getBySlug(Status::SLUG_FROZEN)->id,
        ];
        if ($idea->is_priority && in_array($idea->status_id, $statuses)) {
            $idea->is_priority = 0;
            $idea->save();
        }

        return $this;
    }
}
