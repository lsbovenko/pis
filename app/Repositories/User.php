<?php

namespace App\Repositories;

use App\Models\Auth\User as ModelUser;
use App\Models\Auth\Role as ModelRole;
use Illuminate\Support\Facades\DB;
use App\Models\Categories\Status;

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
            ->rightJoin('ideas', 'users.id', '=', 'ideas.user_id')
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
     * @return string
     */
    protected function getModelClass(): string
    {
        return ModelUser::class;
    }
}
