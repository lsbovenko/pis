<?php

namespace App\Repositories;

use App\Models\Categories\Position as ModelPosition;

/**
 * Class Position
 *
 * @package App\Repositories
 */
class Position extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getModelClass() : string
    {
        return ModelPosition::class;
    }

    public function getPositionByName(string $name)
    {
        $position = ModelPosition::where('name', $name)->first();
        if (!$position) {
            $position = ModelPosition::create([
                'name' => $name,
                'is_active' => ModelPosition::POSITION_ACTIVE,
            ]);
        }

        return $position;
    }
}
