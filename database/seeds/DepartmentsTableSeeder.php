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
            'Отдел PHP разработки',
            'Отдел Ruby разработки',
            'Отдел Frontend разработки',
            'Отдел UI/ UX',
            'Отдел маркетинга и продаж',
            'Отдел кадров',
            'Другой',
        ];
    }
}
