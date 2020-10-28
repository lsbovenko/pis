<?php

namespace App\Handlers\Events;

use Illuminate\Support\Facades\App;
use App\Service\EmailQueueCreator;

/**
 * Class IdeaApproved
 *
 * @package App\Handlers\Events
 */
abstract class AbstractIdea
{
    /**
     * @var EmailQueueCreator
     */
    private $emailQueueService;

    /**
     * @return EmailQueueCreator
     */
    protected function getQueueService()
    {
        if (!$this->emailQueueService) {
            $this->emailQueueService = App::make(EmailQueueCreator::class);
        }
        return $this->emailQueueService;
    }
}
