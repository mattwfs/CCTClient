<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    //use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    function users() {
        return $this->hasMany('App\User')->whereNull("deleted_at");
    }

    public function specializations()
    {
        return $this->belongsToMany('App\Specialization')->orderBy('id','DESC');
    }

    function locations() {
        return $this->hasMany('App\Location')->whereNull("deleted_at");
    }
    
}
