<?php

namespace App\Handlers\Events;

use App\Events\IdeaWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IdeaCreated  $event
     * @return void
     */
    public function handle(IdeaWasCreated $event)
    {
        /*$this
            ->notifyUser($event)
            ->notifySuperadmins($event);*/
    }
}
