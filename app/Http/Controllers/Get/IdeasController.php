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
    Input,
    Auth
};
use App\Models\Categories\Status;

class IdeasController extends Controller
{

    const QUANTITY_ITEMS_ON_PAGE = 15;

    const DEFAULT_LIMIT = 50;

    public function index(Request $request)
    {
        $ideas = $this->getChangeFilter($request)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('is_priority', '=', 0)
            ->paginate($this->checkedLimit($request));

        return response()->json(array_merge([
                'ideas' => $ideas->appends(Input::except('page')),
                'showApproveStatus' => false,
            ],
                $this->getValuesTopUsers()
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function priorityBoard(Request $request)
    {
        $ideas = $this->getChangeFilter($request)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('is_priority', '=', 1)
            ->paginate($this->checkedLimit($request));

        return response()->json(array_merge([
                'ideas' => $ideas->appends(Input::except('page')),
                'title' => 'Приоритетный список',
                'showApproveStatus' => false,
            ],
                $this->getValuesTopUsers()
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myIdeas(Request $request)
    {
        $ideas = $this->getChangeFilter($request)
            ->where('user_id', '=', Auth::user()->id)
            ->paginate($this->checkedLimit($request));

        return response()->json(array_merge([
                'ideas' => $ideas->appends(Input::except('page')),
                'title' => 'Мои идеи',
                'showApproveStatus' => true
            ],
                $this->getValuesTopUsers()
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pendingReview(Request $request)
    {
        $ideas = $this->getChangeFilter($request)
            ->where('approve_status', '=', Idea::NEW)
            ->paginate($this->checkedLimit($request));

        return response()->json(array_merge([
                'ideas' => $ideas->appends(Input::except('page')),
                'title' => 'Ожидают утверждения',
                'showApproveStatus' => false,
            ],
                $this->getValuesTopUsers()
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function declined(Request $request)
    {
        $ideas = $this->getChangeFilter($request)
            ->where('approve_status', '=', Idea::DECLINED)
            ->paginate($this->checkedLimit($request));

        return response()->json(array_merge([
                'ideas' => $ideas->appends(Input::except('page')),
                'title' => 'Отклоненные идеи',
                'showApproveStatus' => false,
            ],
                $this->getValuesTopUsers()
            )
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilter()
    {
        return response()->json([
            'filter' => $this->getValuesForFilter(),
            'status' => $this->availableStatuses(),
            'users' => $this->getActiveUsers()
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

        $orderBy = (isset($input['orderDir'])) ? $input['orderDir'] : '';
        if ($orderBy == 'asc') {
            $query->orderBy('id', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
        }

        if (isset($input['user_id'])) {
            $userId = $input['user_id'];
            $query->where('user_id', '=', $userId);
        }

        return $query;
    }

    protected function getValuesTopUsers()
    {
        return [
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
        ];
    }

    protected function checkedLimit(Request $request)
    {
        $limit = (int)$request->get('limit', self::DEFAULT_LIMIT);
        $reslimit = $limit <= self::DEFAULT_LIMIT ? $limit : self::DEFAULT_LIMIT;
        return $reslimit;
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
    protected function getActiveUsers()
    {
        return App::make('repository.user')->getTopUsers(Status::getActiveStatus(), null, null, 20, 1);
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
        return App::make('repository.user')->getTopUsers(Status::getCompletedStatus(), null, $date);
    }
}