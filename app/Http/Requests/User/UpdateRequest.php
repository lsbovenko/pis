<?php

namespace App\Http\Requests\User;

/**
 * Class UpdateRequest
 * @package App\Http\Requests\User
 */
class UpdateRequest extends AbstractRequest
{
    /**
     * @return array
     */
    protected function getEmailValidator() : array
    {
        //todo добавить проверку уникальности, если изменен
        return ['email' => 'required|email'];
    }
}
