<?php

namespace App\Service;

use App\Models\Categories\Status;
use App\Models\Auth\User;
use App\Models\{Comment, Idea, Note};
use App\Events\{CommentAdded, IdeaWasCreated, IdeaWasApproved, IdeaWasDeclined, IdeaWasChangedStatus, Like\LikeAdded};

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
        $idea->coreCompetencies()->attach($data['core_competency_id']);
        $idea->departments()->attach($data['department_id']);
        $idea->operationalGoals()->attach($data['operational_goal_id']);
        $idea->strategicObjectives()->attach($data['strategic_objective_id']);

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
        $idea->coreCompetencies()->sync($data['core_competency_id'], 1);
        $idea->departments()->sync($data['department_id'], 1);
        $idea->operationalGoals()->sync($data['operational_goal_id'], 1);
        $idea->strategicObjectives()->sync($data['strategic_objective_id'], 1);

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

        $reasonModel = $idea->getPriorityReason();
        if ($reasonModel === null) {
            Note::create([
                'text' => $reason,
                'idea_id' => $idea->id,
                'type' => Note::TYPE_PRIORITY_REASON,
            ]);
        } else {
            $reasonModel->text = $reason;
            $reasonModel->save();
        }

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
            throw new \App\Exceptions\PriorityReasonNotFound('Пояснительная записка не найденa');
        }

        $reason->text = $text;
        $reason->save();
        return $idea;
    }

    /**
     * @param Idea $idea
     * @param Status $status
     * @return Idea
     * @throws \App\Exceptions\IdeaIsNotApproved
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

    /**
     * @param Idea $idea
     * @param $user
     */
    public function addPostLike(Idea $idea, User $user)
    {
        if ($this->isUserHasLike($user, $idea->id)) {
            $idea->likes_num++;
            $idea->save();

            $this->addLikeIdeasUser($idea, $user);
        }
    }

    /**
     * @param Idea $idea
     * @param $user
     * @return bool
     */
    public function removeLike(Idea $idea, User $user) : bool
    {
        if (!$this->isUserHasLike($user, $idea->id)) {
            $idea->likes_num--;
            $idea->save();
            $user->likedUserIdea()->detach($idea->id);
        }
    }

    /**
     * @param User $user
     * @param int $ideaId
     * @return bool
     */
    public function isUserHasLike(User $user, int $ideaId) : bool
    {
        $likesUsers = $user->checkUserLike($ideaId);

        return !$likesUsers;
    }

    /**
     * @param Idea $idea
     * @return bool
     */
    public function increaseAmountComment(Idea $idea, int $userId, string $message) : bool
    {
        $idea->comments_count++;
        $idea->save();

        $comment = new Comment;
        $comment->idea_id = $idea->id;
        $comment->user_id = $userId;
        $comment->message = $message;
        $comment->save();

        //send email
        event(new CommentAdded($comment));

        return true;
    }

    /**
     * @param int $ideaId
     * @param $user
     * @return bool
     */
    private function addLikeIdeasUser(Idea $idea, User $user) : bool
    {
        $user->likedUserIdea()->attach($idea->id);

        if(!$user->getLikeNotification($idea->id)) {
            $user->likeNotification()->attach($idea->id);

            event(new LikeAdded($idea));
        }

        return true;
    }
}