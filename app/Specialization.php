<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    
     public $timestamps = false;
     
     public function users(){
          return $this->belongsToMany('App\User')->where("user_type","clinic")->whereNull("deleted_at");
     }

    public function clinics(){
        return $this->belongsToMany('App\Clinic')->whereNull("deleted_at");
    }
    
   /* public function users(){
        return $this->hasMany('App\User');
    }
    
    
    public function trials(){
        return $this->hasMany('App\Trial');
    }*/
    
}
