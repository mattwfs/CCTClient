<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    function user() {
        return $this->belongsTo('App\User');
    }
    
    function trial() {
        return $this->belongsTo('App\Trial');
    }
}
