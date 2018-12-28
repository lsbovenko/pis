<?php
/**
 * Created by PhpStorm.
 * User: valeriy
 * Date: 26.12.18
 * Time: 16:48
 */

namespace App\Models;


use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}