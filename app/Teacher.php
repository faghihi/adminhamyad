<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Teacher extends Model
{
    protected $table='teachers';
    protected $fillabel = ['name','resume_link','description',
        'phone','email','background','education',
        'work_ex','awards','image'
    ];

    public static function boot()
    {
        parent::boot();
        Course::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * ManyToMany with Course table
     * Pivot table is course_teachers table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course' ,'course_teachers')
            ->withTimestamps();
    }
    public function rates()
    {
        return $this->belongsToMany('App\User' ,'teacher_rates')
            ->withPivot('rate')
            ->withTimestamps();
    }
}
