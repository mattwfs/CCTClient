<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    //use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    function users() {
        return $this->hasMany('App\User')->whereNull("deleted_at");
    }

}
