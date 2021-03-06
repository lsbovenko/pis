<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\EntrustFacade;
use App\Models\Idea;
use Illuminate\Http\Request;
use App\Models\Categories\Status;

/**
 * Class EdotIdeaController
 *
 * @package App\Http\Controllers
 */
class ReviewIdeaController extends Controller
{
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
        /** @var \App\Models\Idea $idea */
        $idea = Idea::findOrFail($request->route('id'));

        if (!$idea->isApproved() && EntrustFacade::hasRole(['user', 'admin']) && $idea->user_id != Auth::user()->id) {
            abort(404);
        }

        $user = Auth::user();

        $likedUserId = '';
        $likedUser = $user->checkUserLike($idea->id);

        if ($likedUser) {
            $likedUserId = $likedUser->pivot->user_id;
        }

        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');

        return view(
            'review-idea.review',
            [
            'idea' => $idea,
            'user' => (!empty($idea->user)) ? $idea->user : null,
            'priorityReason' => $idea->is_priority ? $idea->getPriorityReason() : null,
            'statuses' => $reference->getAllStatusesForSelect(),
            'status' => $idea->status,
            'countUserIdea' => $user->ideas()->count(),
            'authUser' => [
                'user' => $user,
                'userLike' => $likedUserId,
                'listUsersLike' => $idea->users
            ],
            'comments' => $idea->comments,
            'activeStatusId' => Status::getActiveStatus()->id,
            'completedStatusId' => Status::getCompletedStatus()->id,
            'executorsList' => $reference->getAllExecutorsForSelect(),
            ]
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getComments(Request $request)
    {
        /** @var \App\Models\Idea $idea */
        $idea = Idea::query()->where('id', '=', $request->route('id'))
            ->with('comments', 'comments.user')
            ->get()
            ->first();

        /** @var \App\Models\CommentLike $commentLikes */
        $commentLikes = DB::table('comment_likes')
            ->join('comments', 'comments.id', '=', 'comment_likes.comment_id')
            ->select(DB::raw('comment_likes.*'))
            ->where('comment_likes.is_removed', 0)
            ->where('comments.idea_id', $request->id)
            ->get();

        if (isset($idea)) {
            return [
                'count' => $idea->comments_count,
                'comments' => $idea->comments,
                'ideas' => trans('ideas'),
                'commentsLikes' => $commentLikes,
                'currentUserId' => Auth::user()->id
            ];
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request)
    {
        /** @var \App\Models\Idea $idea */
        $idea = Idea::findOrFail($request->route('id'));
        $data = App::make('datacleaner')->cleanData($request->all());
        $status = (int)$data['status'];

        if ($status === Idea::DECLINED) {
            $this->validate(
                $request,
                [
                'reason' => 'required|min:5',
                ]
            );
        }

        try {
            if ($status === Idea::DECLINED) {
                $this->getIdeaControl()->decline($idea, $data['reason']);
            } else {
                $this->getIdeaControl()->approve($idea);
            }
        } catch (\App\Exceptions\IdeaApproved $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Изменения успешно сохранены.');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function pinToPriority(Request $request)
    {
        /** @var \App\Models\Idea $idea */
        $idea = Idea::findOrFail($request->route('id'));
        $data = App::make('datacleaner')->cleanData($request->all());
        $this->validate(
            $request,
            [
            'reason_priority' => 'required|min:5',
            ]
        );

        try {
            $this->getIdeaControl()->pinToPriority($idea, $data['reason_priority']);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Изменения успешно сохранены.');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function unpinToPriority(Request $request)
    {
        /** @var \App\Models\Idea $idea */
        $idea = Idea::findOrFail($request->route('id'));
        try {
            $this->getIdeaControl()->unpinToPriority($idea);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Изменения успешно сохранены.');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changePriorityReason(Request $request)
    {
        /** @var \App\Models\Idea $idea */
        $idea = Idea::findOrFail($request->route('id'));
        $data = App::make('datacleaner')->cleanData($request->all());
        $this->validate(
            $request,
            [
            'reason_priority' => 'required|min:5',
            ]
        );

        try {
            $this->getIdeaControl()->changePriorityReason($idea, $data['reason_priority']);
        } catch (\App\Exceptions\PriorityReasonNotFound $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Изменения успешно сохранены.');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addComment(Request $request)
    {
        /** @var \App\Models\Idea $idea */
        $idea = Idea::findOrFail($request->route('id'));
        $data = App::make('datacleaner')->cleanData($request->all(), ['message']);
        $this->validate(
            $request,
            [
            'message' => 'required|min:2|max:10000'
            ]
        );

        $user = Auth::user();

        try {
            if ($idea->isApproved()) {
                $this->getIdeaControl()->increaseAmountComment($idea, $user->id, $data['message']);
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }

        return response()->json(
            [
            'status' => 'success',
            'message' => 'Комментарий успешно добавлен'
            ]
        );
    }

    /**
     * @return \App\Service\IdeaControl
     */
    protected function getIdeaControl() : \App\Service\IdeaControl
    {
        return App::make('idea.control');
    }
}
