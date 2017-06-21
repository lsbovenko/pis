<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Auth\User;

class DeleteData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $emails = [
            'goncharovln21v@gmail.com',
            'vellumweb@gmail.com',
            'support@ikantam.com',
        ];

        $mainEmail = 'slava@ikantam.com';

        $mainUser = User::where('email', '=', $mainEmail)->first();
        $users = User::whereIn('email', $emails)->get();

        foreach ($users as $user) {
            foreach ($user->ideas()->get() as $idea) {
                $idea->user_id = $mainUser->id;
                $idea->save();
            }
            $user->delete();
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
