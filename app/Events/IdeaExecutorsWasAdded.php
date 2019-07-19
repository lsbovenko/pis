<?php

namespace App\Events;

use App\Models\Idea;

/**
 * Class IdeaExecutorsWasAdded
 * @package App\Events
 */
class IdeaExecutorsWasAdded  extends IdeaWasAbstract
{
    protected $executors;

    public function __construct(Idea $idea, $executors)
    {
        parent::__construct($idea);
        $this->executors = $executors;
    }

    public function getExecutors()
    {
        return $this->executors;
    }
}
