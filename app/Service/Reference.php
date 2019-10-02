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
     * @param bool $isFilter
     * @return array
     */
    public function getAllCoreCompetencyForSelect($isFilter = false) : array
    {
        return (App::make('repository.coreCompetency'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllOperationalGoalForSelect($isFilter = false) : array
    {
        return (App::make('repository.operationalGoal'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllStrategicObjectiveForSelect($isFilter = false) : array
    {
        return (App::make('repository.strategicObjective'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllTypeForSelect($isFilter = false) : array
    {
        return (App::make('repository.type'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllDepartmentForSelect($isFilter = false) : array
    {
        return (App::make('repository.department'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllRolesForSelect($isFilter = false) : array
    {
        return (App::make('repository.role'))->getAllForSelect($isFilter, false);
    }

    /**
     * @return array
     */
    public function getAllStatusesForSelect($isFilter = false) : array
    {
        return (App::make('repository.status'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllPositionsForSelect($isFilter = false) : array
    {
        return (App::make('repository.position'))->getAllForSelect($isFilter);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllTagForSelect($isFilter = false) : array
    {
        return (App::make('repository.tag'))->getAllForSelect($isFilter, false);
    }

    /**
     * @param bool $isFilter
     * @return array
     */
    public function getAllExecutorsForSelect($isFilter = false) : array
    {
        $repository = App::make('repository.user');

        if ($isFilter) {
            $executors = $repository->getExecutorsForFilter();
            foreach ($executors as $executor) {
                $res[] = [
                    'id' => $executor->id,
                    'name' => $executor->name . ' ' . $executor->last_name //$executor instanceof \stdClass
                ];
            }
        } else {
            $executors = $repository->getActiveExecutors();
            foreach ($executors as $executor) {
                $res[$executor->id] = $executor->getFullName();
            }
        }

        return (!empty($res)) ? $res : [];
    }

    /**
     * @param string $searchSimilarIdea
     * @param array $similarIdeaIds
     * @param integer|null $ideaId
     * @return array
     */
    public function getApprovedSearchIdeasForSelect(string $searchSimilarIdea, array $similarIdeaIds, int $ideaId=null) : array
    {
        $repository = App::make('repository.idea');

        $approvedSearchIdeas = $repository->getApprovedSearchIdeas($searchSimilarIdea, $similarIdeaIds, $ideaId);
        foreach ($approvedSearchIdeas as $approvedSearchIdea) {
            $res[] = ['value' => $approvedSearchIdea->id, 'label' => $approvedSearchIdea->title];
        }

        return (!empty($res)) ? $res : [];
    }

    /**
     * @param integer $ideaId
     * @return array
     */
    public function getSimilarIdeasForList(int $ideaId) : array
    {
        $repository = App::make('repository.idea');

        $similarIdeas = $repository->getSimilarIdeas($ideaId);
        foreach ($similarIdeas as $similarIdea) {
            $res[] = ['id' => $similarIdea->id, 'name' => $similarIdea->title];
        }

        return (!empty($res)) ? $res : [];
    }
}