<?php

namespace App\Repositories;

use App\Models\Auth\User as ModelUser;
use App\Models\Auth\Role as ModelRole;

/**
 * Class User
 * @package App\Repositories
 */
class User extends AbstractRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return ModelUser::all();
    }

    /**
     * @param $role
     * @param int $isActive
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @throws \Exception
     */
    public function getByRole($role, $isActive = 1)
    {
        if (is_string($role)) {
            $role = ModelRole::where('name', '=', $role)->first();
        }

        if (!($role instanceof ModelRole)) {
            throw new \Exception('Role not found');
        }

        return $role->users()
            ->where('is_active', '=', $isActive)
            ->whereNotNull('password');
    }

    /**
     * @param int $isActive
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getSuperadmins($isActive = 1)
    {
        return $this->getByRole(ModelRole::ROLE_SUPERADMIN, $isActive);
    }

    /**
     * @param int $isActive
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getAdmins($isActive = 1)
    {
        return $this->getByRole(ModelRole::ROLE_ADMIN, $isActive);
    }

    /**
     * @return string
     */
    protected function getModelClass() : string
    {
        return ModelUser::class;
    }
}