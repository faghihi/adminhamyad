<?php

namespace App;



use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Review extends Model

{
//    use SoftDeletes;
    protected $table='reviews';
    protected $fillable = ['comment','section_rate','user_id','course_rate','enable'];

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        Review::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * ManyToMany with Course Table
     * Pivot table is course_reviews table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_reviews')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Section Table
     * Pivot table is section_reviews table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sections()
    {
        return $this->belongsToMany('App\Section', 'section_reviews')
            ->withTimestamps();
    }

    /**
     * ManyToMany with TV table
     * Pivot table is tv_reviews table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'teacher_reviews')
            ->withTimestamps();
    }
}