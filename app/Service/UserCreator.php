<?php

namespace App\Service;

use App\Models\Auth\User;
use App\Models\Auth\Role;
use App\Models\Categories\Department;
use App\Models\Categories\Position;

/**
 * Class UserCreator
 *
 * @package App\Service
 */
class UserCreator
{
    const DEFAULT_ROLE = 'user';
    const SERVICE_NAME = 'pis';

    /**
     * @param array $payload
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createFromJwt(array $payload)
    {
        $userData = $payload['user'];
        $userData['email'] = $payload['sub'];
        if (empty($userData)) {
            throw new \Exception('Payload is empty');
        }

        $userData['department_id'] = $this->getDepartment($userData)->id;
        $userData['position_id'] = $this->getPosition($userData)->id;
        $role = $this->getRole($userData);
        $user = User::create($userData);
        $user->attachRole($role);

        return $user;
    }

    /**
     * @param array $userData
     * @return $this|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function getRole(array $userData)
    {
        $roleName = $userData['roles'][self::SERVICE_NAME] ?? self::DEFAULT_ROLE;
        $role = Role::where('name', '=', $roleName)->get()->first();
        if (!$role) {
            $role = Role::create(['name' => $roleName]);
        }

        return $role;
    }

    /**
     * @param array $userData
     * @return $this|\Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     */
    protected function getPosition(array $userData)
    {
        $positionName = $userData['position'];
        if (!$positionName) {
            throw new \Exception('Position is empty');
        }

        $position = Position::where('name', '=', $positionName)->get()->first();
        if (!$position) {
            $position = Position::create(['name' => $positionName, 'is_active' => 1]);
        }

        return $position;
    }

    /**
     * @param array $userData
     * @return $this|\Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     */
    protected function getDepartment(array $userData)
    {
        $departmentName = $userData['department'];
        if (!$departmentName) {
            throw new \Exception('Department is empty');
        }

        $department = Department::where('name', '=', $departmentName)->get()->first();
        if (!$department) {
            $department = Department::create(['name' => $departmentName, 'is_active' => 1]);
        }

        return $department;
    }
}
