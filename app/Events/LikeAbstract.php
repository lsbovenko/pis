<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 18.01.19
 * Time: 12:32
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Idea;

abstract class LikeAbstract
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Idea
     */
    protected $idea;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * @return Idea
     */
    public function getIdea() : Idea
    {
        return $this->idea;
    }
}