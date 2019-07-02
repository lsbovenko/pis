<?php

namespace App\Repositories;

use App\Models\Categories\Status as ModelStatus;

/**
 * Class Role
 * @package App\Repositories
 */
class Status extends AbstractRepository
{
    /**
     * @param string $slug
     * @return null | \App\Models\Categories\Status
     */
    public function getBySlug(string $slug)
    {
        return ModelStatus::where('slug', '=', $slug)->first();
    }

    /**
     * @return string
     */
    protected function getModelClass() : string
    {
        return ModelStatus::class;
    }

    /**
     * @param bool $isFilter
     * @param bool $isActiveFieldExists
     * @return array
     */
    public function getAllForSelect(bool $isFilter, bool $isActiveFieldExists = true) : array
    {
        $res = [];
        $query = ($this->getModelClass())::where('is_active', '1')->orderBy('id', 'asc');
        foreach ($query->get() as $model) {
            $res[$model->id] = $model->getDisplayNameField();
        }

        return $res;
    }
}