<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class IdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \App\Service\Reference $reference */
        $reference = App::make('reference');

        return [
            'title' => 'required|max:255|string|min:6',
            'description' => 'required|max:5000|string|min:10',
            'department_id' => [
                Rule::in(array_keys($reference->getAllDepartmentForSelect())),
                'required',
            ],
            'core_competency_id' => [
                Rule::in(array_keys($reference->getAllCoreCompetencyForSelect())),
                'required',
            ],
            'operational_goal_id' => [
                Rule::in(array_keys($reference->getAllOperationalGoalForSelect())),
                'required',
            ],
            'strategic_objective_id' => [
                Rule::in(array_keys($reference->getAllStrategicObjectiveForSelect())),
                'required',
            ],
            'type_id' => [
                Rule::in(array_keys($reference->getAllTypeForSelect())),
                'required',
            ],
        ];
    }
}
