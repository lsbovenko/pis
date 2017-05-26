<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //todo
        User::create(
            [
                'email' => 'foo@bar.com'
            ]
        );
    }
}
