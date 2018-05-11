<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    
    protected $fillable = [
        'question', 'trial_id', 'status',
    ];
    
    
    public function answers() {
        return $this->hasMany('App\Answer');
    }
    
    public function trial() {
        return $this->belongsTo('App\Trial');
    }
    
    
}
