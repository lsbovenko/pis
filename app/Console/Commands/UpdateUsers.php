<?php

namespace App\Console\Commands;

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $apiClient = new AuthV2ApiClient();
            $authUsers = $apiClient->getActiveUsers();

            foreach ($authUsers as $authUser) {
                $user = User::where('email', $authUser['email'])->first();

                if ($user) {
                    $user->name = $authUser['firstName'];
                    $user->last_name = $authUser['lastName'];
                    $user->is_active = $authUser['active'];
                    $user->external_id = $authUser['externalId'];

                    if (isset($authUser['avatar']['small'])) {
                        $user->avatar = $authUser['avatar']['small'];
                    }

                    $position = Position::where('id', '=', $user->position_id)->get()->first();
                    if ($position->name != $authUser['position'] && $authUser['position'] != '') {
                        $newPosition = Position::where('name', '=', $authUser['position'])->get()->first();
                        if (empty($newPosition)) {
                            $newPosition = Position::create(['name' => $authUser['position'], 'is_active' => 1]);
                        }
                        $user->position_id = $newPosition->id;
                    }

                    $department = Department::where('id', '=', $user->department_id)->get()->first();
                    if ($department->name != $authUser['department'] && $authUser['department'] != '') {
                        $newDepartment = Department::where('name', '=', $authUser['department'])->get()->first();
                        if (empty($newDepartment)) {
                            $newDepartment = Department::create(['name' => $authUser['department'], 'is_active' => 1]);
                        }
                        $user->department_id = $newDepartment->id;
                    }

                    $user->save();
                }
            }
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            Log::error($e);
        }
    }
}
