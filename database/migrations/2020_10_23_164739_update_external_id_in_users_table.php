<?php

use App\Models\Auth\User;
use App\Service\AuthV2ApiClient;
use Illuminate\Database\Migrations\Migration;

class UpdateExternalIdInUsersTable extends Migration
{
    private $authUsers;

    public function __construct()
    {
        $apiClient = new AuthV2ApiClient();
        $this->authUsers = $apiClient->getActiveUsers();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->authUsers as $authUser) {
            User::where('email', $authUser['email'])->update(['external_id' => $authUser['externalId']]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->authUsers as $authUser) {
            User::where('email', $authUser['email'])->update(['external_id' => NULL]);
        }
    }
}
