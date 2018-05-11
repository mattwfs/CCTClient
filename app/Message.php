<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    function user() {
        return $this->belongsTo('App\User');
    }
    
    function conversation() {
        return $this->belongsTo('App\Message');
    }
}
