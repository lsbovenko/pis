<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 22.01.19
 * Time: 11:49
 */

namespace App\Handlers\Events;

use App\Events\LikeAdded;
use App\Mail\IdeaLikeNotify\ToUser;

class IdeaLikeNotification extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  LikeAdded $event
     * @return void
     */
    public function handle(LikeAdded $event)
    {
        $this->notifyUser($event);
    }

    /**
     * @param LikeAdded $event
     * @return $this
     */
    protected function notifyUser(LikeAdded $event)
    {
        $user = $event->getIdea()->user()->first();
        if ($user->is_active == 1) {
            $this->getQueueService()->add($user->email, new ToUser($event->getIdea()));
        }

        return $this;
    }
}