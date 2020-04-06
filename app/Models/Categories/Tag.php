<?php

namespace App\Models\Categories;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'id';

    /**
     * disable update timestamp fields
     *
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

    /**
     * @return string
     */
    public function getDisplayNameField() : string
    {
        return $this->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ideas()
    {
        return $this->belongsToMany(Idea::class, 'ideas_tags', 'tag_id', 'idea_id', 'id', 'id');
    }
}
