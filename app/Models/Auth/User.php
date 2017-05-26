<?php

namespace App\Models\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Junaidnasir\Larainvite\InviteTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use InviteTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'department_id',
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
}
