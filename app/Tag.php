<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @package App
 * @property string $tag_name
 */
class Tag extends Model
{
//    use SoftDeletes;

    protected $table='tags';
    protected $fillable = ['tag_name'];

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        Tag::observe(new \App\Observers\UserActionsObserver);

    }

    /**
     * ManyToMany with Course Table
     * Pivot table is course_tag table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_tag')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Category Table
     * Pivot table is category_tag table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_tag')
            ->withTimestamps();

    }
}

