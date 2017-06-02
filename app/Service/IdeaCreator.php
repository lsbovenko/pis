<?php

namespace App\Service;

use App\Models\Categories\Status;

/**
 * Class IdeaCreator
 * @package App\Service
 */
class IdeaCreator
{
    public function create($user, array $data, Status $status)
    {
        $idea = (new \App\Models\Idea($data));
        //$idea->user_id = $user->id;//todo
        $idea->user_id = 1;
        $idea->status_id = $status->id;
        $idea->save();

        event(new \App\Events\IdeaWasCreated($idea));
    }
}