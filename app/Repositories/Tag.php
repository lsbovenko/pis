<?php

namespace App\Repositories;

use App\Models\Categories\Tag as ModelTag;

/**
 * Class Tag
 * @package App\Repositories
 */
class Tag extends AbstractRepository
{
    protected function getModelClass() : string
    {
        return ModelTag::class;
    }
}