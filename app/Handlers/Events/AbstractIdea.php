<?php

namespace App\Handlers\Events;

use App\Repositories\RemoteUser;
use Illuminate\Support\Facades\App;
use App\Service\EmailQueueCreator;

/**
 * Class IdeaApproved
 * @package App\Handlers\Events
 */
abstract class AbstractIdea
{
    /**
     * @var EmailQueueCreator
     */
    private $emailQueueService;

    /**
     * @return RemoteUser
     */
    protected function getRemoteUserRepository(): RemoteUser
    {
        return App::make('repository.remote_user');
    }

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
