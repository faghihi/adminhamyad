<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
//    use SoftDeletes;

    protected $table='courses';
    protected $fillable = ['name', 'description', 'price','image'];

    /**
     * @return void
     */
    public static function boot()

    {
        parent::boot();
        Course::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * ManyToMany with Tag Table
     * Pivot table is course_tag table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'course_tag')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Review Table
     * Pivot table is course_reviews table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->belongsToMany('App\Review', 'course_reviews')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Teacher Table
     * Pivot table is course_teachers table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'course_teachers')
            ->withTimestamps();
    }

    /**
     * ManyToMany with User Table
     * Pivot table is certificate table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users_certificate()
    {
        return $this->belongsToMany('App\User', 'certificate')
            ->withPivot('point','description')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Course Table
     * Pivot table is take table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users_take()
    {
        return $this->belongsToMany('App\User', 'take')
            ->withPivot('paid','discount_used')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Admin Table
     * Pivot table is course_owners table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany('App\Admin', 'course_owners')
            ->withTimestamps();
    }

    /**
     * ManyToMany with Rate Table
     * Pivot table is course_rates table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rates()
    {
        return $this->belongsToMany('App\User', 'course_rates')
            ->withPivot('rate')
            ->withTimestamps();
    }
    /*
     * * oneToMany with category Table
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function section()
    {
        return $this->hasMany('App\Section');
    }

    public function provider()
    {
        return $this->belongsToMany('App\Provider' ,'provider_courses')
            ->withTimestamps();
    }

    public function packs()
    {
        return $this->belongsToMany('App\Pack' ,'pack_courses')
            ->withTimestamps();
    }
}
