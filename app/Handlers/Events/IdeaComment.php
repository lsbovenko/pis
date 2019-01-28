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
        $user = Auth::user();
        $this->notifyAll($event, $user);
    }

    /**
     * @param CommentAdded $event
     * @return $this
     */
    protected function notifyAll(CommentAdded $event, User $user)
    {
        $resultEmails = [];
        foreach ($this->getRemoteUserRepository()->getAll() as $item) {
            $resultEmails[] = $item['email'];
        }

        $userEmails = array_diff($resultEmails, [$user->email]);

        foreach ($userEmails as $email) {
            $this->getQueueService()->add($email, new ToAll($event->getComment()));
        }

        return $this;
    }
}