<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{
    App,
    Log
};

use App\Models\Idea;
use Illuminate\Http\Request;

/**
 * Class EdotIdeaController
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
        return view('review-idea.review', [
            'idea' => $idea,
            'user' => $idea->user()->first(),
            'coreCompetency' => $idea->coreCompetency()->first(),
            'department' => $idea->department()->first(),
            'operationalGoal' => $idea->operationalGoal()->first(),
            'strategicObjective' => $idea->strategicObjective()->first(),
            'type' => $idea->type()->first(),
        ]);
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
            $this->validate($request, [
                'reason' => 'required|min:5',
            ]);
        }

        try {
            if ($status === Idea::DECLINED) {
                App::make('idea.control')->decline($idea, $data['reason']);
            } else {
                App::make('idea.control')->approve($idea);
            }
        } catch (\App\Exceptions\IdeaApproved $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back();
        }

        return redirect()->route('main');
    }
}
