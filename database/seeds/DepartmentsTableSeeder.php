<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getDepartments() as $department) {
            Department::create(
                [
                    'name' => $department
                ]
            );
        }
    }

    protected function getDepartments()
    {
        return [
            'PHP Department',
            'Ruby Department',
            'Front-end Department',
            'UX/UI Department',
            'Sales Department',
            'HR Department',
            'Other',
        ];
    }
}
