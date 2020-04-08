<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\{
    User,
    Role
};
use App\Models\Categories\Department;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            Role::ROLE_USER => Role::where('name', '=', Role::ROLE_USER)->first(),
            Role::ROLE_ADMIN => Role::where('name', '=', Role::ROLE_ADMIN)->first(),
            Role::ROLE_SUPERADMIN => Role::where('name', '=', Role::ROLE_SUPERADMIN)->first(),
        ];
        $department = Department::where('name', '=', 'Other')->first();

        foreach ($this->getUsers() as $user) {
            $userModel = User::create(
                [
                    'email' => $user['email'],
                    'name' => $user['name'],
//                    'password' => bcrypt($user['pass']),
                    'department_id' => $department->id,
                    'position_id' => 1,
                    'is_active' => 1,
                ]
            );
            $userModel->attachRole($roles[$user['role']]);
        }
    }


    protected function getUsers()
    {
        return [
            [
                'role' => Role::ROLE_SUPERADMIN,
                'name' => 'Гончаров Леонид',
                'email' => 'leonid@ikantam.com',
                'pass' => '123456',
            ],
            /*[
                'role' => Role::ROLE_USER,
                'name' => 'user1',
                'email' => 'user1@mail.ru',
                'pass' => '123456',
            ],
            [
                'role' => Role::ROLE_USER,
                'name' => 'user2',
                'email' => 'user2@mail.ru',
                'pass' => '123456',
            ],
            [
                'role' => Role::ROLE_ADMIN,
                'name' => 'admin1',
                'email' => 'admin1@mail.ru',
                'pass' => '123456',
            ],
            [
                'role' => Role::ROLE_ADMIN,
                'name' => 'admin2',
                'email' => 'admin2@mail.ru',
                'pass' => '123456',
            ],
            [
                'role' => Role::ROLE_SUPERADMIN,
                'name' => 'superadmin1',
                'email' => 'superadmin1@mail.ru',
                'pass' => '123456',
            ],
            [
                'role' => Role::ROLE_SUPERADMIN,
                'name' => 'superadmin2',
                'email' => 'superadmin2@mail.ru',
                'pass' => '123456',
            ],*/
        ];

    }
}
