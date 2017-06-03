<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasDeclined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\IdeaDeclined\{
    ToUser
};
use Illuminate\Support\Facades\App;

/**
 * Class IdeaDeclined
 * @package App\Handlers\Events
 */
class IdeaDeclined
{
    /**
     * @var \App\Repositories\User
     */
    protected $userRepository;

    /**
     * @var \App\Models\Note
     */
    protected $reason;

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
        $event->getIdea()->user()->first()->notify(new ToUser($event->getIdea(), $this->getDeclinedReason($event)));

        return $this;
    }

    /**
     * @param IdeaWasDeclined $event
     * @return \App\Models\Note
     */
    protected function getDeclinedReason(IdeaWasDeclined $event)
    {
        if (!$this->reason) {
            $this->reason = $event->getIdea()->getDeclinedReason();
        }

        return $this->reason;
    }

    /**
     * @return \App\Repositories\User
     */
    protected function getUserRepository() : \App\Repositories\User
    {
        return App::make('repository.user');
    }
}
