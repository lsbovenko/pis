<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Models\Idea;

class IdeaRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        parent::__construct();
        $validationFactory->extend(
            'similar_ideas_id_validation',
            function ($attribute, $value, $parameters) {
                if ($value) {
                    $similarIdeasId = array_unique(explode(',', $value));

                    return (count($similarIdeasId) === Idea::whereIn('id', $similarIdeasId)->count());
                } else {
                    return true;
                }
            },
            trans('ideas.similar_ideas_id_incorrect')
        );
    }

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
            'description' => 'required|max:50000|string|min:10',
            'core_competency_id' => [
                Rule::in(array_keys($reference->getAllCoreCompetencyForSelect())),
                'required',
                'array',
            ],
            'department_id' => [
                Rule::in(array_keys($reference->getAllDepartmentForSelect())),
                'required',
                'array',
            ],
            'operational_goal_id' => [
                Rule::in(array_keys($reference->getAllOperationalGoalForSelect())),
                'required',
                'array',
            ],
            'type_id' => [
                Rule::in(array_keys($reference->getAllTypeForSelect())),
                'required',
            ],
            'similar_ideas_id' => 'similar_ideas_id_validation',
        ];
    }
}
