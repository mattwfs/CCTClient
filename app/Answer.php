<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    function user() {
        return $this->belongsTo('App\User');
    }
    
    function question() {
        return $this->belongsTo('App\Question');
    }
    
    function trial() {
        return $this->belongsTo('App\Trial');
    }
}
