<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; 

class User extends Authenticatable
{
    //use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }
    
    
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
    
    
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtolower($value);
    }
    
    
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }
    
    
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }
    
    
    
    public function specializations()
    {
        return $this->belongsToMany('App\Specialization')->orderBy('id','DESC');
    }
    
    
    public function answers() {
        return $this->hasMany('App\Answer');
    }
    
    
    public function applications() {
        return $this->hasMany('App\Application')->orderBy('id','DESC')->whereNull("deleted_at");
    }
    
    
    public function referrals() {
        return $this->hasMany('App\Referral')->orderBy('id','DESC');
    }

    public function sales_reps() {
        return $this->hasMany('App\User','sales_manager_id')->orderBy('id','DESC')->whereNull("deleted_at");
    }
    
    public function agreement() {
        return $this->hasOne('App\Agreement');
    }
    
    
    public function investigators(){
        return $this->hasMany('App\Investigator');
    }
    
    /*public function role(){
        return $this->belongsTo('App\Role');
    }*/
    
    
    public function messages(){
        return $this->hasMany('App\Message')->orderBy('id','DESC');
    }

    public function locations(){
        return $this->hasMany('App\Location')->orderBy('id','DESC');
    }
    
    public function finances(){
        return $this->hasMany('App\Finance')->orderBy('id','DESC');
    }

    public function clinic(){
        return $this->belongsTo('App\Clinic')->whereNull("deleted_at");
    }

    public function clinics(){
        return $this->hasMany('App\Clinic','sales_rep')->whereNull("deleted_at");
    }
    
    
    
}
