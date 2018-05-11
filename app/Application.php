<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    function trial() {
        return $this->belongsTo('App\Trial');
    }
    
    function user() {
        return $this->belongsTo('App\User');
    }
    
    function questions() {
        return $this->hasMany('App\Questions');
    }
    
    function attachments() {
        return $this->morphMany('App\Attachment', 'attachable');
    }

    function answers() {
        return $this->hasMany('App\Answer');
    }

    function conversations() {
        return $this->hasMany('App\Conversation');
    }

    function investigator() {
        return $this->belongsTo('App\User',"investigator_id","id");
    }

}
