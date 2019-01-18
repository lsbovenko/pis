<?php

namespace App\Models\Auth;

use App\Models\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\Idea;
use App\Models\Categories\Status;

/**
 * Class User
 * @package App\Models\Auth
 */
class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'department_id',
        'position_id',
        'is_active'
    ];

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return string
     */
    public function getFullName() : string
    {
        return $this->name . ' ' . $this->last_name;
    }
    /**
     * @return int
     */
    public function countActiveIdeas() : int
    {
        $status = Status::getActiveStatus();
        return Idea::where('status_id', '=', isset($status) ? $status->id : 0)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('user_id', '=', $this->id)
            ->count();
    }

    /**
     * @return int
     */
    public function countFrozenIdeas() : int
    {
        $status = Status::getFrozenStatus();
        return Idea::where('status_id', '=', isset($status) ? $status->id : 0)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('user_id', '=', $this->id)
            ->count();
    }

    /**
     * @return int
     */
    public function countCompletedIdeas() : int
    {
        $status = Status::getCompletedStatus();
        return Idea::where('status_id', '=', isset($status) ? $status->id : 0)
            ->where('approve_status', '=', Idea::APPROVED)
            ->where('user_id', '=', $this->id)
            ->count();
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
    public function position()
    {
        return $this->belongsTo('App\Models\Categories\Position');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ideas()
    {
        return $this->hasMany('App\Models\Idea');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedUserIdea()
    {
        return $this->belongsToMany('App\Models\Idea', 'idea_likes')->withTimestamps();
    }

    /**
     * @param $ideaId
     * @return mixed
     */
    public function checkUserLike($ideaId)
    {
        return $this->likedUserIdea()->where('idea_id', $ideaId)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class,'user_id');
    }

    /**
     * this connection ideas that the user like at least once
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likeNotification()
    {
        return $this->belongsToMany(Idea::class, 'like_notifiсations');
    }

    /**
     * @param int $ideaId
     * @return mixed
     */
    public function getLikeNotification(int $ideaId)
    {
        return $this->likeNotification()->where('idea_id', $ideaId)->first();
    }
}
