<?php

namespace App\Repositories;

use App\Models\Categories\Department as ModelDepartment;

/**
 * Class Department
 *
 * @package App\Repositories
 */
class Department extends AbstractRepository
{
    protected function getModelClass() : string
    {
        return ModelDepartment::class;
    }

    public function getDepartmentByName(string $name)
    {
        $department = ModelDepartment::where('name', $name)->first();
        if (!$department) {
            $department = ModelDepartment::create([
                'name' => $name,
                'is_active' => ModelDepartment::DEPARTMENT_ACTIVE,
            ]);
        }

        return $department;
    }
}
