<?php

namespace App\Repositories;

use App\Models\Auth\Role as ModelRole;

/**
 * Class Role
 * @package App\Repositories
 */
class Role extends AbstractRepository
{
    /**
     * @return array
     */
    public function getAllForSelect() : array
    {
        $res = [];
        foreach (ModelRole::orderBy('id', 'desc')->get() as $role)
        {
            $res[$role->id] = $role->display_name;
        }

        return $res;
    }
}