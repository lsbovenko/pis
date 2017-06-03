<?php

namespace App\Service;

use App\Models\Categories\Status;
use App\Models\Auth\User;
use App\Models\{
    Idea,
    Note
};
use App\Events\{
    IdeaWasCreated,
    IdeaWasApproved,
    IdeaWasDeclined
};

/**
 * Class IdeaControl
 * @package App\Service
 */
class IdeaControl
{
    /**
     * @param User $user
     * @param array $data
     * @param Status $status
     * @return Idea
     */
    public function create(User $user, array $data, Status $status)
    {
        $idea = (new Idea($data));
        $idea->user_id = $user->id;
        $idea->status_id = $status->id;
        $idea->approve_status = Idea::NEW;
        $idea->save();

        event(new IdeaWasCreated($idea));

        return $idea;
    }

    /**
     * @param Idea $idea
     * @return Idea
     * @throws \App\Exceptions\IdeaApproved
     */
    public function approve(Idea $idea)
    {
        if ($idea->approve_status !== Idea::NEW) {
            throw new \App\Exceptions\IdeaApproved('Идея уже прошла этап модерации');
        }
        $idea->approve_status = Idea::APPROVED;
        $idea->save();
        event(new IdeaWasApproved($idea));

        return $idea;
    }

    /**
     * @param Idea $idea
     * @return Idea
     * @throws \App\Exceptions\IdeaApproved
     */
    public function decline(Idea $idea, string $reason)
    {
        if ($idea->approve_status !== Idea::NEW) {
            throw new \App\Exceptions\IdeaApproved('Идея уже прошла этап модерации');
        }
        $idea->approve_status = Idea::DECLINED;
        $idea->save();

        Note::create([
            'text' => $reason,
            'idea_id' => $idea->id,
            'type' => Note::TYPE_DECLINED_REASON,
        ]);
        event(new IdeaWasDeclined($idea));

        return $idea;
    }
}