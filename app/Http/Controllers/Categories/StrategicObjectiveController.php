<?php

namespace App\Http\Controllers\Categories;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Categories\StrategicObjective;
use App\Models\Idea;

/**
 * Class StrategicObjectiveController
 *
 * @package App\Http\Controllers
 */
class StrategicObjectiveController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(
            'categories.status.index',
            [
            'items' => StrategicObjective::all(),
            'title' => trans('ideas.strategic_objectives'),
            'route' => 'categories.strategic-objective'
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        /** @var \App\Models\Categories\StrategicObjective $item */
        $item = StrategicObjective::findOrFail($request->route('id'));
        return view(
            'categories.status.edit',
            [
            'item' => $item,
            'title' => trans('ideas.edit_strategic_objective'),
            'route' => route('categories.strategic-objective.edit', ['id' => $item->id]),
            'deleteRoute' => route('categories.strategic-objective.delete', ['id' => $item->id]),
            ]
        );
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request)
    {
        /** @var \App\Models\Categories\StrategicObjective $item */
        $item = StrategicObjective::findOrFail($request->route('id'));
        $input = App::make('datacleaner')->cleanData($request->all());
        $item->fill($input);
        $item->is_active = (int)$input['is_active'];
        $item->save();

        return redirect()->route('categories.strategic-objective.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view(
            'categories.status.edit',
            [
            'title' => trans('ideas.create_strategic_objective'),
            'route' => route('categories.strategic-objective.create')
            ]
        );
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveNew(CategoryRequest $request)
    {
        $input = App::make('datacleaner')->cleanData($request->all());
        StrategicObjective::create($input);

        return redirect()->route('categories.strategic-objective.index');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        /** @var \App\Models\Categories\StrategicObjective $item */
        $item = StrategicObjective::findOrFail($request->route('id'));

        $itemCount = $item->ideas()->count();
        if ($itemCount) {
            return redirect()->back()->withErrors([trans('ideas.unable_delete_ideas_with_task')]);
        }
        $item->delete();

        return redirect()->route('categories.strategic-objective.index');
    }
}
