<?php

namespace App\Console\Commands;

use App\Service\UserSyncService;
use Illuminate\Console\Command;
use App\Models\Auth\User;
use App\Models\Categories\Department;
use App\Models\Categories\Position;
use App\Service\AuthV2ApiClient;
use Illuminate\Support\Facades\Log;

/**
 * Class UpdateUsers
 *
 * @package App\Console\Commands
 */
class UpdateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users from auth';

    private $userSyncService;

    /**
     * Create a new command instance.
     *
     * @param UserSyncService $userSyncService
     * @return void
     */
    public function __construct(UserSyncService $userSyncService)
    {
        parent::__construct();
        $this->userSyncService = $userSyncService;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $apiClient = new AuthV2ApiClient();
            $authUsers = $apiClient->getActiveUsers();
            $this->userSyncService->sync($authUsers, $blockAbsent = true);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            Log::error($e);
        }
    }
}
