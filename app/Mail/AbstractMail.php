<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Idea;

/**
 * Class AbstractMail
 * @package App\Mail\IdeaApproved
 */
abstract class AbstractMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Idea
     */
    protected $idea;

    /**
     * ToAll constructor.
     * @param Idea $idea
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }
}
