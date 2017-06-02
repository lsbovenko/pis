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
            'Другой',
            'Отдел кадров',
            'Отдел маркетинга и продаж',
            'Отдел UI/UX',
            'Отдел Frontend разработки',
            'Отдел Ruby разработки',
            'Отдел PHP разработки',
        ];
    }
}
