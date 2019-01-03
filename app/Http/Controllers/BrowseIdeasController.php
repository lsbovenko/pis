<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{
    App,
    Input,
    Auth
};


use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\Categories\Status;

/**
 * Class BrowseIdeasController
 * @package App\Http\Controllers
 */
class BrowseIdeasController extends Controller
{
    const QUANTITY_ITEMS_ON_PAGE = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $ideas = $this->getQuery($request)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('is_priority', '=',  0)
            ->paginate(self::QUANTITY_ITEMS_ON_PAGE);


        return view('browse-ideas.index', [
            'ideas' => $ideas->appends(Input::except('page')),
            'title' => 'Все идеи',
            'filter' => $this->getValuesForFilter(),
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
            'showApproveStatus' => false
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allIdeas(Request $request) {
        $ideas = $this->getQuery($request)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('is_priority', '=',  0)
            ->paginate(self::QUANTITY_ITEMS_ON_PAGE);
        return response()->json([$ideas]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function priorityBoard(Request $request)
    {
        $ideas = $this->getQuery($request)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('is_priority', '=',  1)
            ->paginate(self::QUANTITY_ITEMS_ON_PAGE);

        return view('browse-ideas.index', [
            'ideas' => $ideas->appends(Input::except('page')),
            'title' => 'Приоритетный список',
            'filter' => $this->getValuesForFilter(),
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
            'showApproveStatus' => false
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myIdeas(Request $request)
    {
        $ideas = $this->getQuery($request)
            ->where('user_id', '=',  Auth::user()->id)
            ->paginate(self::QUANTITY_ITEMS_ON_PAGE);

        return view('browse-ideas.index', [
            'ideas' => $ideas->appends(Input::except('page')),
            'title' => 'Мои идеи',
            'filter' => $this->getValuesForFilter(),
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
            'showApproveStatus' => true
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pendingReview(Request $request)
    {
        $ideas = $this->getQuery($request)
            ->where('approve_status', '=', Idea::NEW)
            ->paginate(self::QUANTITY_ITEMS_ON_PAGE);

        return view('browse-ideas.index', [
            'ideas' => $ideas->appends(Input::except('page')),
            'title' => 'Ожидают утверждения',
            'filter' => $this->getValuesForFilter(),
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
            'showApproveStatus' => false,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function declined(Request $request)
    {
        $ideas = $this->getQuery($request)
            ->where('approve_status', '=', Idea::DECLINED)
            ->paginate(self::QUANTITY_ITEMS_ON_PAGE);

        return view('browse-ideas.index', [
            'ideas' => $ideas->appends(Input::except('page')),
            'title' => 'Отклоненные идеи',
            'filter' => $this->getValuesForFilter(),
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' =>$this->getTopUsersLast3Month(),
            'topUsersByCompletedIdeasLast3Month' => $this->getTopUsersByCompletedIdeasLast3Month(),
            'showApproveStatus' => false
        ]);
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
            'departmentsList' => ['0' => '-- Отдел --'] + $reference->getAllDepartmentForSelect(0, 'is_active', 'desc'),
            'coreCompetenciesList' => ['0' => '-- Основная компетенция --'] + $reference->getAllCoreCompetencyForSelect(0, 'is_active', 'desc'),
            'operationalGoalsList' => ['0' => '-- Операционная цель --'] + $reference->getAllOperationalGoalForSelect(0, 'is_active', 'desc'),
            'strategicObjectivesList' => ['0' => '-- Стратегическая задача --'] + $reference->getAllStrategicObjectiveForSelect(0, 'is_active', 'desc'),
            'typesList' => ['0' => '-- Тип --'] + $reference->getAllTypeForSelect(0, 'is_active', 'desc'),
            'statuses' => ['0' => '-- Статус --'] + $reference->getAllStatusesForSelect(0, 'is_active', 'desc'),
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
