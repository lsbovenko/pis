<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        //$this->call(DepartmentsTableSeeder::class);
        //$this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(CoreCompetenciesTableSeeder::class);
        $this->call(OperationGoalsTableSeederTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(StrategicObjectivesTableSeeder::class);
        $this->call(TypesTableSeeder::class);
    }
}
