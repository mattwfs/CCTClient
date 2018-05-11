<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    
    public $timestamps = false;
    
    function messages() {
        return $this->hasmany('App\Messages');
    }

    function application() {
        return $this->belongsTo('App\Application');
    }
    
}
