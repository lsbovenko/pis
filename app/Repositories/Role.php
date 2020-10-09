<?php

namespace App\Repositories;

use App\Models\Auth\Role as ModelRole;
use App\Models\Auth\User;

/**
 * Class Role
 *
 * @package App\Repositories
 */
class Role extends AbstractRepository
{
    protected function getModelClass() : string
    {
        return ModelRole::class;
    }

    public function updateRole(User $user, array $roles)
    {
        if (in_array(ModelRole::ROLE_SUPERADMIN, $roles)) {
            $name = ModelRole::ROLE_SUPERADMIN;
        } elseif (in_array(ModelRole::ROLE_ADMIN, $roles)) {
            $name = ModelRole::ROLE_ADMIN;
        } else {
            $name = ModelRole::ROLE_USER;
        }
        $role = ModelRole::where('name', $name)->first();

        $user->detachRoles();
        $user->attachRole($role);
    }
}
