<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class UsersRoles extends Model
{
    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        'role_id',
    ];
}
