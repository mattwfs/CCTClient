<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    function user(){
        return $this->belongsTo('App\User');
    }
}
