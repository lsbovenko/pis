<?php

namespace App\Repositories;

use App\Models\Auth\User as ModelUser;
use App\Models\Auth\Role as ModelRole;
use Illuminate\Support\Facades\DB;
use App\Models\Categories\Status;
use App\Models\Idea;

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

        return $role->users
            ->where('is_active', '=', $isActive);
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
     * @param Status|null $status
     * @param \DateTime|null $createdAt
     * @param \DateTime|null $completedAt
     * @param int $limit
     * @param int $approve|null approved status. default 0, active 1
     * @return mixed
     */
    public function getTopUsers(Status $status = null, \DateTime $createdAt = null, \DateTime $completedAt = null,
                                int $limit = 3, int $approve = null)
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        $query = DB::table('users')
            ->join('ideas', 'users.id', '=', 'ideas.user_id')
            ->select(DB::raw('users.*, count(users.id) AS number'))
            ->groupBy('users.id')
            ->orderBy('number', 'DESC')
            ->orderBy('users.id', 'asc');

        if ($status) {
            $query->where('ideas.status_id', '=', $status->id);
        }

        if (isset($approve)) {
            $query->where('ideas.approve_status', '=', $approve);
        }

        if ($createdAt) {
            $query->where('ideas.created_at', '>', $createdAt->format('Y-m-d H:i:s'));
        }

        if ($completedAt) {
            $query->where('ideas.completed_at', '>', $completedAt->format('Y-m-d H:i:s'));
        }

        return $query
            ->limit($limit)
            ->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getActiveUsers(int $limit)
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        $query = DB::table('users')
            ->rightJoin('ideas', 'users.id', '=', 'ideas.user_id')
            ->select(DB::raw('users.*, count(users.id) AS number'))
            ->groupBy('users.id')
            ->orderBy('users.name', 'asc')
            ->orderBy('users.last_name', 'asc');

        $query->where('users.is_active', '=', 1);
        $query->where('ideas.approve_status', '=', Idea::APPROVED);

        return $query
            ->limit($limit)
            ->get();
    }

    /**
     * @param int|null $department
     * @return mixed
     */
    public function getDepartmentUsers(int $department = null)
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        $query = DB::table('users')
            ->rightJoin('ideas', 'users.id', '=', 'ideas.user_id')
            ->select(DB::raw('users.*, count(users.id) AS number'))
            ->groupBy('users.id')
            ->orderBy('users.name', 'asc')
            ->orderBy('users.last_name', 'asc');

        $query->where('users.is_active', '=', 1);
        $query->where('ideas.approve_status', '=', Idea::APPROVED);

        if ($department) {
            $query->where('users.department_id', '=', $department);
        }

        return $query
            ->get();
    }

    /**
     * @return mixed
     */
    public function getExecutorsForFilter()
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        $query = DB::table('ideas_executors as ie')
            ->selectRaw('u.*')
            ->join('users as u', 'ie.executor_id', '=', 'u.id')
            ->where('u.is_active', '=', 1)
            ->groupBy('u.id')
            ->orderBy('u.name', 'asc')
            ->orderBy('u.last_name', 'asc');

        return $query->get();
    }

    /**
     * @return mixed
     */
    public function getActiveExecutors()
    {
        $executors = ModelUser::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->orderBy('last_name', 'asc');

        return $executors->get();
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return ModelUser::class;
    }
}
