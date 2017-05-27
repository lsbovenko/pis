<?php

namespace App\Repositories;

use App\Models\Auth\User as ModelUser;

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
}