<?php

use App\Models\Auth\User;
use App\Models\Categories\Position;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersAndPositionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (App::make('repository.remote_user')->getAll() as $remoteUser) {
            $user = User::where('email', $remoteUser['email'])->first();
            if ($user) {
                $position = Position::where('id', '=', $user->position_id)->get()->first();
                if ($position->name != $remoteUser['position']) {
                    $newPosition = Position::where('name', '=', $remoteUser['position'])->get()->first();
                    if (!$newPosition) {
                        $newPosition = Position::create(['name' => $remoteUser['position'], 'is_active' => 1]);
                    }
                    $user->position_id = $newPosition->id;
                    $user->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
