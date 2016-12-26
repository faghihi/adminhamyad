<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Section extends Model
{
//    use SoftDeletes;

    protected $table='sections';
    protected $fillable = ['name', 'description', 'link', 'part','time','course_id','image'];

    public static function boot()
    {
        parent::boot();
        Course::observe(new \App\Observers\UserActionsObserver);
    }

    public function courses()
    {
        return $this->belongsTo('App\Course','course_id');
    }

    public function reviews()
    {
        return $this->belongsToMany('App\Review', 'section_reviews')
            ->withTimestamps();
    }
    public function rates()
    {
        return $this->belongsToMany('App\NormalUser', 'section_rates','section_id','user_id')
            ->withPivot('rate')
            ->withTimestamps();
    }

    public function favorite_sections()
    {
        return $this->belongsToMany('App\NormalUser', 'favorite_sections','section_id','user_id')
            ->withTimestamps();
    }
}
