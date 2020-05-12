<?php

/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 04.01.19
 * Time: 10:28
 */

namespace App\Http\Controllers\Get;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Idea as ModelIdea;
use Illuminate\Http\Request;
use App\Models\Idea;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        return response()->json(
            array_merge(
                [
                'ideas' => $ideas->appends(Input::except('page')),
                'showApproveStatus' => false,
                ],
                $this->getValuesTopUsers()
            )
        );
    }

    public function getSimilarIdeas(Request $request)
    {
        $searchSimilarIdea = $request->get('search_similar_idea');
        $similarIdeaIds = $request->get('similar_idea_id')
            ? explode(',', $request->get('similar_idea_id'))
            : [];
        $ideaId = $request->get('idea_id');

        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');

        return response()->json(
            $reference->getApprovedSearchIdeasForSelect($searchSimilarIdea, $similarIdeaIds, $ideaId)
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

        return response()->json(
            array_merge(
                [
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

        return response()->json(
            array_merge(
                [
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

        return response()->json(
            array_merge(
                [
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

        return response()->json(
            array_merge(
                [
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
        return response()->json(
            [
            'filter' => $this->getValuesForFilter(),
            'status' => $this->availableStatuses(),
            'users' => $this->getActiveUsers(),
            'ideas' => trans('ideas')
            ]
        );
    }

    /**
     * @param Request                                    $request
     * @param array|null                                 $filterParams
     * @param \Illuminate\Database\Eloquent\Builder|null
     * @return Idea|\Illuminate\Database\Eloquent\Builder
     */
    public function getChangeFilter(Request $request, $filterParams, $searchQueryTitle = null)
    {
        $input = $request->all();

        $query = Idea::with('user.position', 'status', 'executors');

        $query->select('ideas.*');

        foreach ($filterParams as $key => $value) {
            $query->where($key, '=', $value);
        }

        if (isset($input['user_department_id'])) {
            $userDepartmentId = $input['user_department_id'];
            $query->whereHas(
                'user',
                function ($q) use ($userDepartmentId) {
                    $q->where('department_id', $userDepartmentId);
                }
            );
        }

        if (isset($input['department_id'])) {
            $departmentId = $input['department_id'];
            $query->whereHas(
                'departments',
                function ($q) use ($departmentId) {
                    $q->whereIn('id', $departmentId);
                }
            );
        }

        if (isset($input['executor_id'])) {
            $executorId = $input['executor_id'];
            $query->join('ideas_executors as ie', 'ideas.id', '=', 'ie.idea_id');
            $query->where('ie.executor_id', $executorId);
        }

        if (isset($input['core_competency_id'])) {
            $coreCompetencyId = $input['core_competency_id'];
            $query->whereHas(
                'coreCompetencies',
                function ($q) use ($coreCompetencyId) {
                    $q->whereIn('id', $coreCompetencyId);
                }
            );
        }

        if (isset($input['operational_goal_id'])) {
            $operationalGoalId = $input['operational_goal_id'];
            $query->whereHas(
                'operationalGoals',
                function ($q) use ($operationalGoalId) {
                    $q->whereIn('id', $operationalGoalId);
                }
            );
        }

        if (isset($input['strategic_objective_id'])) {
            $strategicObjectiveId = $input['strategic_objective_id'];
            $query->whereHas(
                'strategicObjectives',
                function ($q) use ($strategicObjectiveId) {
                    $q->whereIn('id', $strategicObjectiveId);
                }
            );
        }

        if (!empty($input['tag_id'])) {
            $tagId = $input['tag_id'];
            $query->whereHas(
                'tags',
                function ($q) use ($tagId) {
                    $q->whereIn('id', $tagId);
                }
            );
        }

        if (isset($input['statusId'])) {
            $statusId = $input['statusId'];
            $query->where('status_id', '=', $statusId);
        }

        if (isset($input['type_id'])) {
            $typeId = $input['type_id'];
            $query->whereIn('type_id', $typeId);
        }

        if (isset($input['user_id'])) {
            $userId = $input['user_id'];
            $query->where('ideas.user_id', '=', $userId);
        }

        if (isset($input['is_anonymous'])) {
            $query->whereNull('ideas.user_id');
        }

        if (isset($input['is_liked'])) {
            $user = $request->user();
            $query->join('idea_likes as il', 'ideas.id', '=', 'il.idea_id');
            $query->where('il.user_id', $user->id);
        }

        if (isset($input['idea_age'])) {
            $ideaAge = $input['idea_age'];
            $date = new \DateTime("-$ideaAge days");
            $query->where('ideas.created_at', '<', $date->format('Y-m-d H:i:s'));
        }

        if (isset($input['datepicker_dates'])) {
            $datepickerDates = $input['datepicker_dates'];
            $dates = explode(',', $datepickerDates);
            if (count($dates) == 2) {
                $beginDate = $dates[0] . ' 00:00:00';
                $endDate = $dates[1] . ' 23:59:59';
                $query->whereBetween('ideas.created_at', [$beginDate, $endDate]);
            }
        }

        if (isset($input['search_idea'])) {
            $searchIdea = $input['search_idea'];
            if (!$searchQueryTitle) {
                $query->where('title', 'LIKE', "%$searchIdea%");

                return $query;
            } else {
                $searchQueryDescription = $query->where('description', 'LIKE', "%$searchIdea%");
                $searchQueryResult = $this->getSearchQuery($searchQueryTitle, $searchQueryDescription);
                $searchedIds = [];

                foreach ($searchQueryResult as $idea) {
                    $searchedIds[] = $idea->id;
                }

                $searchQuery = Idea::with('user.position', 'status', 'executors');
                $searchQuery->select('ideas.*');
                $searchQuery->whereIn('ideas.id', $searchedIds);

                $searchedIdsStr = implode(",", $searchedIds);

                //sort ideas by list of searched and ordered ids
                $searchQuery->orderByRaw(DB::raw("FIELD(ideas.id, $searchedIdsStr) ASC"));

                return $searchQuery;
            }
        }

        $orderBy = (isset($input['orderDir'])) ? $input['orderDir'] : '';

        if (empty($input['search_idea'])) {
            switch ($orderBy) {
                case 'old':
                    $query->orderBy('ideas.id', 'ASC');
                    break;
                case 'likes':
                    $query->orderBy('likes_num', 'DESC');
                    break;
                case 'comments':
                    $query->orderBy('comments_count', 'DESC');
                    break;
                case 'likes_comments':
                    $query->orderBy(DB::raw("`likes_num` + `comments_count`"), 'DESC');
                    break;
                default:
                    $query->orderBy('ideas.id', 'DESC');
            }
        }

        return $query;
    }

    protected function getValuesTopUsers()
    {
        return [
            'topUsers' => $this->getTopUsers(),
            'topUsersByCompletedIdeas' => $this->getTopUsersByCompletedIdeas(),
            'topUsersLast3Month' => $this->getTopUsersLast3Month(),
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
    protected function getValuesForFilter(): array
    {
        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');
        return [
            'departmentsList' => $reference->getAllDepartmentForSelect(true),
            'coreCompetenciesList' => $reference->getAllCoreCompetencyForSelect(true),
            'operationalGoalsList' => $reference->getAllOperationalGoalForSelect(true),
            'strategicObjectivesList' => $reference->getAllStrategicObjectiveForSelect(true),
            'typesList' => $reference->getAllTypeForSelect(true),
            'tagsList' => $reference->getAllTagForSelect(true),
            'executorsList' => $reference->getAllExecutorsForSelect(true),
        ];
    }

    /**
     * @return array
     */
    protected function availableStatuses(): array
    {
        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');

        return [
            'status' => $reference->getAllStatusesForSelect()
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
        return App::make('repository.user')->getActiveUsers(20);
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
     * @param  \Illuminate\Http\Request $request
     * @param  array|null               $filterParams
     * @return Idea
     */
    protected function getIdeas($request, $filterParams = null)
    {
        if ($request['search_idea']) {
            $searchQueryTitle = $this->getChangeFilter($request, $filterParams);
            $ideas = $this->getChangeFilter($request, $filterParams, $searchQueryTitle)
                ->paginate($this->checkedLimit($request));
        } else {
            $ideas = $this->getChangeFilter($request, $filterParams)
                ->paginate($this->checkedLimit($request));
        }

        return $ideas;
    }

    /**
     * Get searched ideas(id and priority) by priority (title, description)
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return array
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
            ->selectRaw(
                '
                    c.id,
                    max(c.priority) as priority
                '
            )
            ->groupBy('c.id')
            ->orderBy('priority', 'DESC');

        $searchedItems = $query->get();

        return $searchedItems;
    }
}
