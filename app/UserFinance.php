<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFinance extends Model
{
    protected $table='userfinance';

    public function user(){
        return $this->belongsTo('App\NormalUser','user_id');
    }

}
