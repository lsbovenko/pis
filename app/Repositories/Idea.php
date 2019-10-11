<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Idea as ModelIdea;

/**
 * Class Idea
 * @package App\Repositories
 */
class Idea
{
    /**
     * @param string $searchSimilarIdea
     * @param array $similarIdeaIds
     * @param integer|null $ideaId
     * @return Collection
     */
    public function getApprovedSearchIdeas(string $searchSimilarIdea, array $similarIdeaIds, int $ideaId=null) : Collection
    {
        $query = ModelIdea::where('approve_status', ModelIdea::APPROVED);
        if ($searchSimilarIdea) {
            $query = $query->where('title', 'LIKE', "%$searchSimilarIdea%");
        }
        if ($similarIdeaIds) {
            $query = $query->whereNotIn('id', $similarIdeaIds);
        }
        if ($ideaId) {
            $query = $query->where('id', '!=', $ideaId);
        }

        return $query->orderBy('title', 'asc')->get();
    }

    /**
     * @param integer $ideaId
     * @return Collection
     */
    public function getSimilarIdeas(int $ideaId) : Collection
    {
        $idea = ModelIdea::where('id', $ideaId)->first();
        $similarIdeas = $idea->similarIdeas();

        return $similarIdeas->orderBy('title', 'asc')->get();
    }
}
