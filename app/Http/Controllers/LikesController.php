<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 21.12.18
 * Time: 12:22
 */

namespace App\Http\Controllers;

use App\Events\CommentLikeAdded;
use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Idea;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * @param Request $request
     */
    public function addLike(Request $request)
    {
        $idea = Idea::findOrFail($request->id);
        try {
            if ($idea->isApproved()) {
                $this->getIdeaControl()->addPostLike($idea, Auth::user());
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }
    }

    /**
     * @param Request $request
     */
    public function removeLike(Request $request)
    {
        $idea = Idea::findOrFail($request->id);
        try {
            if ($idea->isApproved()) {
                $this->getIdeaControl()->removeLike($idea, Auth::user());
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }
    }

    public function addLikeComment(Request $request)
    {
        $comment = Comment::find($request->id);

        if ($comment) {
            $commentLike = CommentLike::where('comment_id', '=', $comment->id)
                ->where('user_id', '=', Auth::user()->id)->first();

            if (empty($commentLike)) {
                $commentLike = new CommentLike();
                $commentLike->comment_id = $comment->id;
                $commentLike->user_id = Auth::user()->id;
                //send email notification
                event(new CommentLikeAdded($comment));
            }

            $commentLike->is_removed = 0;
            $commentLike->save();
        }
    }

    public function removeLikeComment(Request $request)
    {
        $commentLike = CommentLike::where('comment_id', '=', $request->id)
            ->where('user_id', '=', Auth::user()->id)->first();

        if (!empty($commentLike)) {
            $commentLike->is_removed = 1;
            $commentLike->save();
        }
    }

    /**
     * @return \App\Service\IdeaControl
     */
    protected function getIdeaControl() : \App\Service\IdeaControl
    {
        return App::make('idea.control');
    }
}
