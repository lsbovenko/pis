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
        return view('categories.status.index', [
            'items' => StrategicObjective::all(),
            'title' => 'Стратегические цели',
            'route' => 'categories.strategic-objective'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        /** @var \App\Models\Categories\StrategicObjective $item */
        $item = StrategicObjective::findOrFail($request->route('id'));
        return view('categories.status.edit', [
            'item' => $item,
            'title' => 'Редактировать элемент',
            'route' => route('categories.strategic-objective.edit', ['id' => $item->id]),
            'deleteRoute' => route('categories.strategic-objective.delete', ['id' => $item->id]),
        ]);
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
        $item->name = $input['name'];
        $item->save();

        return redirect()->route('categories.strategic-objective.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories.status.edit', [
            'title' => 'Создать Стратегическую цель',
            'route' => route('categories.strategic-objective.create')
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveNew(CategoryRequest $request)
    {
        $input = App::make('datacleaner')->cleanData($request->all());
        StrategicObjective::create(['name' => $input['name']]);

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

        $itemCount = Idea::where('strategic_objective_id', '=', $item->id)->count();
        if ($itemCount) {
            return redirect()->back()->withErrors(['Невозможно удалить элемент. Существуют идеи с такой целью']);
        }
        $item->delete();

        return redirect()->route('categories.strategic-objective.index');
    }
}
