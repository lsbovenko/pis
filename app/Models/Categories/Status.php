<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package App\Models\Categories
 */
class Status extends Model
{
    const SLUG_ACTIVE = 'active';
    const SLUG_FROZEN = 'frozen';
    const SLUG_COMPLETED = 'completed';

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
        'slug'
    ];

    /**
     * @return string
     */
    public function getDisplayNameField() : string
    {
        return $this->name;
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public static function createNew(string $slug)
    {
        return self::create(
            [
                'slug' => $slug,
                'name' => $slug,
            ]
        );
    }
}
