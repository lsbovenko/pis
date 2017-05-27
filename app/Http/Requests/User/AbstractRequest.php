<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\{
    Department as DepartmentRepository,
    Role as RoleRepository
};

abstract class AbstractRequest extends FormRequest
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
    public function rules(DepartmentRepository $departmentRepository, RoleRepository $roleRepository)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'department_id' => [
                Rule::in(array_keys($departmentRepository->getAllForSelect())),
                'required',
            ],
            'role_id' => [
                Rule::in(array_keys($roleRepository->getAllForSelect())),
                'required',
            ],
        ];

        return array_merge($rules, $this->getEmailValidator());
    }

    /**
     * @return array
     */
    abstract protected function getEmailValidator() : array;
}
