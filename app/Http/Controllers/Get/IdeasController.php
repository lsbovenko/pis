<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 04.01.19
 * Time: 10:28
 */

namespace App\Http\Controllers\Get;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;
use Illuminate\Support\Facades\{
    App,
    Input
};
use App\Models\Categories\Status;

class IdeasController extends Controller
{

    const QUANTITY_ITEMS_ON_PAGE = 15;

    public function index(Request $request)
    {
        $defaultLimit = 50;
        $limit = (int)$request->get('limit', $defaultLimit);
        $limit = $limit <= $defaultLimit ? $limit : $defaultLimit;

        $ideas = $this->getChangeFilter($request)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('is_priority', '=',  0)
            ->paginate($limit);

        return response()->json([
            'ideas' => $ideas->appends(Input::except('page')),
            'totalIdeas' => $ideas->total(),
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
            'showApproveStatus' => false
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilter()
    {
        return response()->json([
            'filter' => $this->getValuesForFilter(),
            'status' => $this->availableStatuses()
        ]);
    }

    /**
     * @param Request $request
     * @return Idea|\Illuminate\Database\Eloquent\Builder
     */
    public function getChangeFilter(Request $request)
    {
        $input = $request->all();

        $query = Idea::with('user.position', 'status');

        if (isset($input['department_id'])) {
            $departmentId = $input['department_id'];
            $query->whereHas('departments', function ($q) use ($departmentId) {
                $q->whereIn('id', $departmentId);
            });
        }

        if (isset($input['core_competency_id'])) {
            $coreCompetencyId = $input['core_competency_id'];
            $query->whereHas('coreCompetencies', function($q) use ($coreCompetencyId) {
                $q->whereIn('id', $coreCompetencyId);
            });
        }

        if (isset($input['operational_goal_id'])) {
            $operationalGoalId = $input['operational_goal_id'];
            $query->whereHas('operationalGoals', function ($q) use ($operationalGoalId) {
                $q->whereIn('id', $operationalGoalId);
            });
        }

        if (isset($input['strategic_objective_id'])) {
            $strategicObjectiveId = $input['strategic_objective_id'];
            $query->whereHas('strategicObjectives', function($q) use ($strategicObjectiveId) {
                $q->whereIn('id', $strategicObjectiveId);
            });
        }

        if (isset($input['statusId'])) {
            $statusId = $input['statusId'];
            $query->where('status_id', '=',  $statusId);
        }

        if (isset($input['type_id'])) {
            $typeId = $input['type_id'];
            $query->whereIn('type_id',  $typeId);
        }

        $orderBy = $request->get('order_by');
        if ($orderBy == 'asc') {
            $query->orderBy('id', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
        }

        return $query;
    }

    /**
     * handle request
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    protected function getQuery(Request $request)
    {

        $query = Idea::with('user.position', 'status');
        if ($departmentId = $request->get('department_id')) {
            $query->whereHas('departments', function($q) use ($departmentId) {
                $q->where('id', '=', $departmentId);
            });
        }
        if ($operationalGoalId = $request->get('operational_goal_id')) {
            $query->whereHas('operationalGoals', function($q) use ($operationalGoalId) {
                $q->where('id', '=', $operationalGoalId);
            });
        }
        if ($strategicObjectiveId = $request->get('strategic_objective_id')) {
            $query->whereHas('strategicObjectives', function($q) use ($strategicObjectiveId) {
                $q->where('id', '=', $strategicObjectiveId);
            });
        }
        if ($typeId = $request->get('type_id')) {
            $query->where('type_id', '=',  $typeId);
        }
        if ($statusId = $request->get('status_id')) {
            $query->where('status_id', '=',  $statusId);
        }
        if ($coreCompetencyId = $request->get('core_competency_id')) {
            $query->whereHas('coreCompetencies', function($q) use ($coreCompetencyId) {
                $q->where('id', '=', $coreCompetencyId);
            });
        }
        $orderBy = $request->get('order_by');
        if ($orderBy == 'asc') {
            $query->orderBy('id', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
        }

        return $query;
    }

    /**
     * @return array
     */
    protected function getValuesForFilter() : array
    {
        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');
        return [
            'departmentsList' => $reference->getAllDepartmentForSelect(0, 'is_active', 'desc'),
            'coreCompetenciesList' => $reference->getAllCoreCompetencyForSelect(0, 'is_active', 'desc'),
            'operationalGoalsList' => $reference->getAllOperationalGoalForSelect(0, 'is_active', 'desc'),
            'strategicObjectivesList' => $reference->getAllStrategicObjectiveForSelect(0, 'is_active', 'desc'),
            'typesList' => $reference->getAllTypeForSelect(0, 'is_active', 'desc'),
        ];
    }

    /**
     * @return array
     */
    protected function availableStatuses() : array
    {
        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');

        return [
            'status' => $reference->getAllStatusesForSelect(0, 'is_active', 'desc')
        ];
    }

    /**
     * @return mixed
     */
    protected function getTopUsers()
    {
        return App::make('repository.user')->getTopUsers();
    }

    /**
     * @return mixed
     */
    protected function getTopUsersByCompletedIdeas()
    {
        return App::make('repository.user')->getTopUsers(Status::getCompletedStatus());
    }

    /**
     * @return mixed
     */
    protected function getTopUsersLast3Month()
    {
        $date = new \DateTime('-3 month');
        return App::make('repository.user')->getTopUsers(null, $date);
    }

    /**
     * @return mixed
     */
    protected function getTopUsersByCompletedIdeasLast3Month()
    {
        $date = new \DateTime('-3 month');
        return App::make('repository.user')->getTopUsers(Status::getCompletedStatus(), $date);
    }
}