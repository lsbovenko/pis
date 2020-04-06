<?php

namespace App\Repositories;

/**
 * Class AbstractRepository
 *
 * @package App\Repositories
 */
abstract class AbstractRepository
{
    /**
     * @param bool $isFilter
     * @param bool $isActiveFieldExists
     * @return array
     */
    public function getAllForSelect(bool $isFilter, bool $isActiveFieldExists = true) : array
    {
        $res = [];
        $query = ($isActiveFieldExists)
            ? ($this->getModelClass())::orderBy('is_active', 'desc')->orderBy('name', 'asc')
            : ($this->getModelClass())::orderBy('name', 'asc');
        foreach ($query->get() as $model) {
            $name = $model->getDisplayNameField();

            if ($model->is_active === 0) {
                $name .= ' (устаревш.)';
            }

            if ($isFilter) {
                $res[] = ['id' => $model->id, 'name' => $name];
            } else {
                $res[$model->id] = $name;
            }
        }

        return $res;
    }

    /**
     * @return string
     */
    abstract protected function getModelClass() : string;
}
