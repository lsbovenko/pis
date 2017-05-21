<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * disable update timestamp fields
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
