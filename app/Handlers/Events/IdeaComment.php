<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 17.01.19
 * Time: 13:30
 */

namespace App\Handlers\Events;

use App\Events\CommentAdded;
use App\Mail\IdeaComment\ToAll;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class IdeaComment extends AbstractIdea
{
    /**
     * Handle the event.
     *
     * @param  CommentAdded $event
     * @return void
     */
    public function handle(CommentAdded $event)
    {
        $this->notifySuperadminsAndIdeaAuthor($event);
    }

    /**
     * @param CommentAdded $event
     * @return $this
     */
    protected function notifySuperadminsAndIdeaAuthor(CommentAdded $event)
    {
        $ideaAuthor = $event->getComment()->idea()->first()->user;
        $commentAuthor = $event->getComment()->user()->first();

        if ($ideaAuthor->is_active == 1 && $ideaAuthor->id !== $commentAuthor->id) {
            $users = App::make('repository.user')->getSuperadmins();
            $emails = [];
            foreach ($users as $user) {
                if ($user->id !== $commentAuthor->id) {
                    $emails[] = $user->email;
                }
            }
            if (!in_array($ideaAuthor->email, $emails)) {
                $emails[] = $ideaAuthor->email;
            }

            $this->getQueueService()->add($emails, new ToAll($event->getComment()));
        }

        return $this;
    }
}