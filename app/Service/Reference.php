<?php

namespace App\Service;

use Illuminate\Support\Facades\App;

/**
 * Class Reference
 * @package App\Service
 */
class Reference
{
    /**
     * @return array
     */
    public function getAllCoreCompetencyForSelect() : array
    {
        return (App::make('repository.coreCompetency'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllOperationalGoalForSelect() : array
    {
        return (App::make('repository.operationalGoal'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllStrategicObjectiveForSelect() : array
    {
        return (App::make('repository.strategicObjective'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllTypeForSelect() : array
    {
        return (App::make('repository.type'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllDepartmentForSelect() : array
    {
        return (App::make('repository.department'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllRolesForSelect() : array
    {
        return (App::make('repository.role'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllStatusesForSelect() : array
    {
        return (App::make('repository.status'))->getAllForSelect();
    }

    /**
     * @return array
     */
    public function getAllPositionsForSelect() : array
    {
        return (App::make('repository.position'))->getAllForSelect();
    }
}