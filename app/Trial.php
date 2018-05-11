<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trial extends Model
{
    use SoftDeletes;
    
    public function attachments() {
         return $this->morphMany('App\Attachment', 'attachable');
    }
    
    public function specialization() {
        return $this->belongsTo('App\Specialization');
    }
    
    function applications() {
        return $this->hasMany('App\Application')->whereNull("deleted_at");
    }
    
    
    function questions() {
        return $this->hasMany('App\Question');
    }

}
