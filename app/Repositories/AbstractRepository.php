<?php

namespace App\Repositories;

/**
 * Class AbstractRepository
 * @package App\Repositories
 */
abstract class AbstractRepository
{
    /**
     * @param string $order
     * @return array
     */
    public function getAllForSelect($sortField = 'id', $order = 'asc') : array
    {
        $res = [];
        foreach (($this->getModelClass())::orderBy($sortField, $order)->get() as $model)
        {
            $res[$model->id] = $model->getDisplayNameField();
        }

        return $res;
    }

    /**
     * @return string
     */
    abstract protected function getModelClass() : string;
}