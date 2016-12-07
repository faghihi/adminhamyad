<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table='categorys';

    protected $fillable = ['name', 'description','icon'];

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        Tag::observe(new \App\Observers\UserActionsObserver);

    }


    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'category_tag')
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->hasMany('App\Course');
    }
    
}
