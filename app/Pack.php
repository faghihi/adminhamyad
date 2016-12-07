<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
//    use SoftDeletes;

    protected $table='packs';
    protected $fillable = ['title' ,'price_day','price_month','price_year','image'];

    /**
     * @return void
     */
    public static function boot()

    {
        parent::boot();
        Course::observe(new \App\Observers\UserActionsObserver);
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course' ,'pack_courses')
            ->withTimestamps();
    }
    public function takes()
    {
        return $this->belongsToMany('App\User', 'takepack')
            ->withPivot('start','end','paid','discount_used')
            ->withTimestamps();
    }
}
