<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Idea;

/**
 * Class IdeaExecutorsWasRemoved
 * @package App\Events
 */
class IdeaExecutorsWasRemoved  extends IdeaWasAbstract
{
    protected $executors;

    public function __construct(Idea $idea, Collection $executors)
    {
        parent::__construct($idea);
        $this->executors = $executors;
    }

    public function getExecutors()
    {
        return $this->executors;
    }
}
