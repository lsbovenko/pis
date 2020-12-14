<?php

namespace App\Repositories;

use App\Models\Categories\Tag as ModelTag;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Tag
 *
 * @package App\Repositories
 */
class Tag extends AbstractRepository
{
    protected function getModelClass() : string
    {
        return ModelTag::class;
    }

    /**
     * @param array $tagIds
     * @return Collection
     */
    public function getPopularTagsByIds(array $tagIds): Collection
    {
        return ModelTag::whereIn('id', $tagIds)->orderBy('name', 'asc')->get();
    }

    /**
     * @return Collection
     */
    public function getAllTags(): Collection
    {
        return ModelTag::orderBy('name', 'asc')->get();
    }
}
