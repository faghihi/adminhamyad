<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
//    use SoftDeletes;
    protected $table="providers";

    protected $fillable=['name','description'];

    public function courses()
    {
        return $this->belongsToMany('App\Course' ,'provider_courses')
            ->withTimestamps();
    }

}
