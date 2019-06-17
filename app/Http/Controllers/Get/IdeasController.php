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
    Auth,
    DB
};
use App\Models\Categories\Status;

class IdeasController extends Controller
{

    const QUANTITY_ITEMS_ON_PAGE = 15;

    const DEFAULT_LIMIT = 50;

    public function index(Request $request)
    {
        $filterParams = [
            'approve_status' => Idea::APPROVED,
            'is_priority' => 0
        ];

        $ideas = $this->getIdeas($request, $filterParams);

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
        $filterParams = [
            'approve_status' => Idea::APPROVED,
            'is_priority' => 1
        ];

        $ideas = $this->getIdeas($request, $filterParams);

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
        $filterParams = [
            'user_id' => Auth::user()->id
        ];

        $ideas = $this->getIdeas($request, $filterParams);

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
        $filterParams = [
            'approve_status' => Idea::NEW
        ];

        $ideas = $this->getIdeas($request, $filterParams);

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
        $filterParams = [
            'approve_status' => Idea::DECLINED
        ];

        $ideas = $this->getIdeas($request, $filterParams);

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
     * @param array|null $filterParams
     * @param \Illuminate\Database\Eloquent\Builder|null
     * @return Idea|\Illuminate\Database\Eloquent\Builder
     */
    public function getChangeFilter(Request $request, $filterParams, $searchQueryTitle = null)
    {
        $input = $request->all();

        $query = Idea::with('user.position', 'status');

        foreach ($filterParams as $key => $value) {
            $query->where($key, '=', $value);
        }

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

        if (isset($input['user_id'])) {
            $userId = $input['user_id'];
            $query->where('user_id', '=', $userId);
        }

        if (isset($input['idea_age'])) {
            $ideaAge = $input['idea_age'];
            $date = new \DateTime("-$ideaAge days");
            $query->where('created_at', '<', $date->format('Y-m-d H:i:s'));
        }

        if (isset($input['search_idea'])) {
            $searchIdea = $input['search_idea'];
            if (!$searchQueryTitle) {
                $query->where('title', 'LIKE', "%$searchIdea%");

                return $query;
            } else {
                $searchQueryDescription = $query->where('description','LIKE', "%$searchIdea%");

                $query = $this->getSearchQuery($searchQueryTitle, $searchQueryDescription);
            }
        }

        $orderBy = (isset($input['orderDir'])) ? $input['orderDir'] : '';
        if ($orderBy == 'asc') {
            $query->orderBy('id', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
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

    /**
     * Get ideas with pagination
     *
     * @param \Illuminate\Http\Request $request
     * @param array|null $filterParams
     * @return Idea
     */
    protected function getIdeas($request, $filterParams = null)
    {
        if ($request['search_idea']) {
            $searchQueryTitle = $this->getChangeFilter($request, $filterParams);
            $ideas = $this->getChangeFilter($request, $filterParams, $searchQueryTitle)
                ->paginate($this->checkedLimit($request));

            $ideas = $this->getSearchResponse($ideas);
        } else {
            $ideas = $this->getChangeFilter($request, $filterParams)
                ->paginate($this->checkedLimit($request));
        }

        return $ideas;
    }

    /**
     * Get structure of search response is the same as the structure of the other filter responses
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getSearchResponse($ideas)
    {
        foreach ($ideas as &$idea) {
            $user = new \stdClass();
            $user->id = $idea->user_id;
            $user->name = $idea->user_name;
            $user->email = $idea->user_email;
            $user->created_at = $idea->user_created_at;
            $user->updated_at = $idea->user_updated_at;
            $user->department_id = $idea->user_department_id;
            $user->position_id = $idea->user_position_id;
            $user->is_active = $idea->user_is_active;
            $user->last_name = $idea->user_last_name;
            $idea->user = $user;

            $position = new \stdClass();
            $position->id = $idea->user_position_id;
            $position->name = $idea->position_name;
            $position->is_active = $idea->position_is_active;
            $user->position = $position;

            $status = new \stdClass();
            $status->id = $idea->status_id;
            $status->name = $idea->status_name;
            $status->slug = $idea->status_slug;
            $status->is_active = $idea->status_is_active;
            $idea->status = $status;
        }

        return $ideas;
    }

    /**
     * Get search query by priority (title, description)
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getSearchQuery($searchQueryTitle, $searchQueryDescription)
    {
        $queryTitle = DB::table(DB::raw("({$searchQueryTitle->toSql()}) as a"))
            ->mergeBindings($searchQueryTitle->getQuery())
            ->selectRaw('a.*, 1 as priority');
        $queryDescription = DB::table(DB::raw("({$searchQueryDescription->toSql()}) as b"))
            ->mergeBindings($searchQueryDescription->getQuery())
            ->selectRaw('b.*, 0 as priority');

        $query = $queryTitle->union($queryDescription);

        $query = DB::table(DB::raw("({$query->toSql()}) as c"))
            ->mergeBindings($query)
            ->selectRaw('
                        c.id,
                        any_value(c.created_at) as created_at, any_value(c.updated_at) as updated_at,
                        any_value(c.title) as title, any_value(c.description) as description,
                        any_value(c.type_id) as type_id, any_value(c.user_id) as user_id,
                        any_value(c.status_id) as status_id, any_value(c.approve_status) as approve_status,
                        any_value(c.is_priority) as is_priority, any_value(c.likes_num) as likes_num,
                        any_value(c.comments_count) as comments_count, any_value(c.completed_at) as completed_at,
                        any_value(c.details) as details,
                        max(c.priority) as priority,
                        any_value(u.name) as user_name, any_value(u.email) as user_email,
                        any_value(u.created_at) as user_created_at, any_value(u.updated_at) as user_updated_at,
                        any_value(u.department_id) as user_department_id, any_value(u.position_id) as user_position_id,
                        any_value(u.is_active) as user_is_active, any_value(u.last_name) as user_last_name,
                        any_value(p.name) as position_name, any_value(p.is_active) as position_is_active,
                        any_value(s.name) as status_name, any_value(s.slug) as status_slug,
                        any_value(s.is_active) as status_is_active')
            ->join('users as u', 'c.user_id', '=', 'u.id')
            ->join('positions as p', 'u.position_id', '=', 'p.id')
            ->join('statuses as s', 'c.status_id', '=', 's.id')
            ->groupBy('c.id')
            ->orderBy('priority', 'DESC');

        return $query;
    }
}