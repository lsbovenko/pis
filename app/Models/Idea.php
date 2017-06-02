<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'core_competency_id',
        'operational_goal_id',
        'strategic_objective_id',
        'department_id',
        'type_id',
    ];

    /**
     * @return string
     */
    public function getDisplayNameField() : string
    {
        return $this->title;
    }
}
