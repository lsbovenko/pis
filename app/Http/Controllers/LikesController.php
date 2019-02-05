<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 21.12.18
 * Time: 12:22
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{
    App,
    Log,
    Auth
};
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

    /**
     * @return \App\Service\IdeaControl
     */
    protected function getIdeaControl() : \App\Service\IdeaControl
    {
        return App::make('idea.control');
    }

}