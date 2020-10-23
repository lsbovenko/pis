<?php

namespace App\Service;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\UsersRoles;
use App\Models\Categories\Department;
use App\Models\Categories\Position;

/**
 * Class UserSyncService
 *
 * @package App\Service
 */
class UserSyncService
{
    /**
     * @param array $authUsers
     * @param bool $blockAbsent
     */
    public function sync(array $authUsers, $blockAbsent = false)
    {
        $departmentNames = [];
        $positionNames = [];
        $externalIds = [];
        foreach ($authUsers as $authUser) {
            if ($authUser->department && !in_array($authUser->department, $departmentNames)) {
                $departmentNames[] = $authUser->department;
            }
            if ($authUser->position && !in_array($authUser->position, $positionNames)) {
                $positionNames[] = $authUser->position;
            }
            $externalIds[] = $authUser->externalId;
        }
        if (!empty($departmentNames)) {
            $departmentsData = $this->syncDepartments($departmentNames);
        }
        if (!empty($positionNames)) {
            $positionsData = $this->syncPositions($positionNames);
        }
        if ($blockAbsent) {
            $this->syncNotActiveUsers($externalIds);
        }
        $usersData = $this->syncActiveUsers($authUsers, $departmentsData, $positionsData);
        $this->syncRolesActiveUsers($authUsers, $usersData);
    }

    /**
     * @param array $departmentNames
     * @return array
     */
    private function syncDepartments(array $departmentNames): array
    {
        $excludeDepartments = Department::whereIn('name', $departmentNames);
        $excludeDepartments->update(['is_active' => Department::DEPARTMENT_ACTIVE]);
        $excludeDepartmentNames = $excludeDepartments->pluck('name')->toArray();
        $newDepartmentNames = array_diff($departmentNames, $excludeDepartmentNames);
        $departments = [];
        foreach ($newDepartmentNames as $departmentName) {
            $departments[] = [
                'name' => $departmentName,
                'is_active' => Department::DEPARTMENT_ACTIVE,
            ];
        }
        Department::insert($departments);

        return Department::where('is_active', Department::DEPARTMENT_ACTIVE)
            ->pluck('id', 'name')->toArray();
    }

    /**
     * @param array $positionNames
     * @return array
     */
    private function syncPositions(array $positionNames): array
    {
        $excludePositions = Position::whereIn('name', $positionNames);
        $excludePositions->update(['is_active' => Position::POSITION_ACTIVE]);
        $excludePositionNames = $excludePositions->pluck('name')->toArray();
        $newPositionNames = array_diff($positionNames, $excludePositionNames);
        $positions = [];
        foreach ($newPositionNames as $positionName) {
            $positions[] = [
                'name' => $positionName,
                'is_active' => Position::POSITION_ACTIVE,
            ];
        }
        Position::insert($positions);

        return Position::where('is_active', Position::POSITION_ACTIVE)
            ->pluck('id', 'name')->toArray();
    }

    /**
     * @param array $externalIds
     */
    private function syncNotActiveUsers(array $externalIds)
    {
        if (!empty($externalIds)) {
            User::whereNotIn('external_id', $externalIds)->orWhereNull('external_id')
                ->update(['is_active' => User::USER_NOT_ACTIVE]);
        }
    }

    /**
     * @param array $authUsers
     * @param array $departmentsData
     * @param array $positionsData
     * @return array
     */
    private function syncActiveUsers(array $authUsers, array $departmentsData, array $positionsData): array
    {
        $usersParams = [];
        foreach ($authUsers as $authUser) {
            $userParams = [
                'name' => $authUser->firstName,
                'last_name' => $authUser->lastName,
                'email' => $authUser->email,
                'is_active' => (int)$authUser->active,
                'avatar' => !empty($authUser->avatar) ? $authUser->avatar->small : null,
                'department_id' => !empty($authUser->department)
                    ? $departmentsData[$authUser->department]
                    : null,
                'position_id' => !empty($authUser->position)
                    ? $positionsData[$authUser->position]
                    : null,
            ];
            $user = User::where('external_id', $authUser->externalId)->first();
            if ($user) {
                $user->update($userParams);
            } else {
                $userParams['external_id'] = $authUser->externalId;
                $usersParams[] = $userParams;
            }
        }
        User::insert($usersParams);

        return User::where('is_active', User::USER_ACTIVE)
            ->pluck('id', 'external_id')->toArray();
    }

    /**
     * @param array $authUsers
     * @param array $usersData
     */
    private function syncRolesActiveUsers(array $authUsers, array $usersData)
    {
        $userIds = [];
        $rolesUsersIds = [];
        $rolesData = Role::all()->pluck('id', 'name')->toArray();
        foreach ($authUsers as $authUser) {
            $userId = $usersData[$authUser->externalId];
            $userIds[] = $userId;

            if (in_array(Role::ROLE_SUPERADMIN, $authUser->roles)) {
                $name = Role::ROLE_SUPERADMIN;
            } elseif (in_array(Role::ROLE_ADMIN, $authUser->roles)) {
                $name = Role::ROLE_ADMIN;
            } else {
                $name = Role::ROLE_USER;
            }
            $rolesUsersIds[] = [
                'user_id' => $userId,
                'role_id' => $rolesData[$name],
            ];
        }
        UsersRoles::whereIn('user_id', $userIds)->delete();
        UsersRoles::insert($rolesUsersIds);
    }
}
