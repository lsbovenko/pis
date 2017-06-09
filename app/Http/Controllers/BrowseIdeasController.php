<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{
    App,
    Input
};


use Illuminate\Http\Request;
use App\Models\Idea;

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
     * @return \Illuminate\Http\Response
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
        ]);
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
            $query->where('department_id', '=',  $departmentId);
        }
        if ($operationalGoalId = $request->get('operational_goal_id')) {
            $query->where('operational_goal_id', '=',  $operationalGoalId);
        }
        if ($strategicObjectiveId = $request->get('strategic_objective_id')) {
            $query->where('strategic_objective_id', '=',  $strategicObjectiveId);
        }
        if ($typeId = $request->get('type_id')) {
            $query->where('type_id', '=',  $typeId);
        }
        if ($statusId = $request->get('status_id')) {
            $query->where('status_id', '=',  $statusId);
        }
        if ($coreCompetencyId = $request->get('core_competency_id')) {
            $query->where('core_competency_id', '=',  $coreCompetencyId);
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
            'coreCompetenciesList' => array_merge(['0' => '-- Основная компетенция --'], $reference->getAllCoreCompetencyForSelect()),
            'operationalGoalsList' => array_merge(['0' => '-- Оперативная цель --'], $reference->getAllOperationalGoalForSelect()),
            'strategicObjectivesList' => array_merge(['0' => '-- Стратегическая цель --'], $reference->getAllStrategicObjectiveForSelect()),
            'typesList' => array_merge(['0' => '-- Тип --'], $reference->getAllTypeForSelect()),
            'departmentsList' => array_merge(['0' => '-- Отдел --'], $reference->getAllDepartmentForSelect()),
            'statuses' => array_merge(['0' => '-- Статус --'], $reference->getAllStatusesForSelect()),
        ];
    }
}
