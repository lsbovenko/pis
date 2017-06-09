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
    IdeaWasDeclined,
    IdeaWasChangedStatus
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
     * @param array $data
     * @return Idea
     */
    public function update(Idea $idea, array $data)
    {
        $idea->fill($data);
        $idea->save();

        return $idea;
    }

    /**
     * @param Idea $idea
     * @return Idea
     * @throws \App\Exceptions\IdeaApproved
     */
    public function approve(Idea $idea)
    {
        if (!$idea->isNew()) {
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
        if (!$idea->isNew()) {
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

    /**
     * @param Idea $idea
     * @param string $reason
     * @return Idea
     */
    public function pinToPriority(Idea $idea, string $reason)
    {
        $idea->is_priority = 1;
        $idea->save();

        Note::create([
            'text' => $reason,
            'idea_id' => $idea->id,
            'type' => Note::TYPE_PRIORITY_REASON,
        ]);

        return $idea;
    }

    /**
     * @param Idea $idea
     * @return Idea
     */
    public function unpinToPriority(Idea $idea)
    {
        $idea->is_priority = 0;
        $idea->save();

        $reason = $idea->getPriorityReason();
        if ($reason !== null) {
            $reason->delete();
        }

        return $idea;
    }

    /**
     * @param Idea $idea
     * @param string $text
     * @return Idea
     * @throws \App\Exceptions\PriorityReasonNotFound
     */
    public function changePriorityReason(Idea $idea, string $text)
    {
        $reason = $idea->getPriorityReason();
        if ($reason === null) {
            throw new \App\Exceptions\PriorityReasonNotFound('Резюме не найдено');
        }

        $reason->text = $text;
        $reason->save();
        return $idea;
    }

    /**
     * @param Idea $idea
     * @param Status $status
     * @return Idea
     */
    public function changeStatus(Idea $idea, Status $status)
    {
        if (!$idea->isApproved()) {
            throw new \App\Exceptions\IdeaIsNotApproved('Вы не можете изменить статус неутвержденной идеи');
        }
        if ($idea->status_id !== $status->id) {
            $idea->status_id = $status->id;
            $idea->save();

            event(new IdeaWasChangedStatus($idea));
        }

        return $idea;
    }
}