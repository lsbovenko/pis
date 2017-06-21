<?php

namespace App\Http\Controllers\Categories;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Categories\OperationalGoal;
use App\Models\Idea;

/**
 * Class OperationalGoalController
 * @package App\Http\Controllers
 */
class OperationalGoalController extends Controller
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
            'items' => OperationalGoal::all(),
            'title' => 'Оператиные цели',
            'route' => 'categories.operational-goal'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        /** @var \App\Models\Categories\OperationalGoal $item */
        $item = OperationalGoal::findOrFail($request->route('id'));
        return view('categories.status.edit', [
            'item' => $item,
            'title' => 'Редактировать элемент',
            'route' => route('categories.operational-goal.edit', ['id' => $item->id]),
            'deleteRoute' => route('categories.operational-goal.delete', ['id' => $item->id]),
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request)
    {
        /** @var \App\Models\Categories\OperationalGoal $item */
        $item = OperationalGoal::findOrFail($request->route('id'));
        $input = App::make('datacleaner')->cleanData($request->all());
        $item->fill($input);
        $item->is_active = (int)$input['is_active'];
        $item->save();

        return redirect()->route('categories.operational-goal.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories.status.edit', [
            'title' => 'Создать Операционную цель',
            'route' => route('categories.operational-goal.create')
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveNew(CategoryRequest $request)
    {
        $input = App::make('datacleaner')->cleanData($request->all());
        OperationalGoal::create($input);

        return redirect()->route('categories.operational-goal.index');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        /** @var \App\Models\Categories\OperationalGoal $item */
        $item = OperationalGoal::findOrFail($request->route('id'));

        $itemCount = Idea::where('operational_goal_id', '=', $item->id)->count();
        if ($itemCount) {
            return redirect()->back()->withErrors(['Невозможно удалить элемент. Существуют идеи с такой целью']);
        }
        $item->delete();

        return redirect()->route('categories.operational-goal.index');
    }
}
