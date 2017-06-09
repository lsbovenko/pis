<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Idea
 * @package App\Models
 */
class Idea extends Model
{
    const NEW = 0;
    const APPROVED = 1;
    const DECLINED = 2;

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

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return bool
     */
    public function isDeclined() : bool
    {
        return $this->approve_status === self::DECLINED;
    }

    /**
     * @return bool
     */
    public function isApproved() : bool
    {
        return $this->approve_status === self::APPROVED;
    }

    /**
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->approve_status === self::NEW;
    }

    /**
     * return \App\Models\Note
     */
    public function getDeclineReason()
    {
        return $this->notes()->where('type', '=', \App\Models\Note::TYPE_DECLINED_REASON)->first();
    }

    /**
     * return \App\Models\Note
     */
    public function getPriorityReason()
    {
        return $this->notes()->where('type', '=', \App\Models\Note::TYPE_PRIORITY_REASON)->first();
    }

    /**
     * @return string
     */
    public function getDisplayNameField() : string
    {
        return $this->title;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coreCompetency()
    {
        return $this->belongsTo('App\Models\Categories\CoreCompetency');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Categories\Department');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operationalGoal()
    {
        return $this->belongsTo('App\Models\Categories\OperationalGoal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function strategicObjective()
    {
        return $this->belongsTo('App\Models\Categories\StrategicObjective');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\Categories\Type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Categories\Status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }
}
