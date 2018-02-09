<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailQueue
 * @package App\Models
 */
class EmailQueue extends Model
{
    protected $table = 'email_queue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'payload',
    ];
}
