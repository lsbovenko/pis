<?php

namespace App\Repositories;

use App\Models\Categories\Department as ModelDepartment;

/**
 * Class Department
 * @package App\Repositories
 */
class Department extends AbstractRepository
{
    /**
     * @return array
     */
    public function getAllForSelect() : array
    {
        $res = [];
        foreach (ModelDepartment::orderBy('id')->get() as $department)
        {
            $res[$department->id] = $department->name;
        }

        return $res;
    }
}