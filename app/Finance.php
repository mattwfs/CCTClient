<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    
    public function setEarningsAmountAttribute($value)
    {
        $this->attributes['earnings_amount'] = preg_replace("/[^0-9]/","",$value);
    }
    
    
    /*public function getEarningsAmountAttribute($value)
    {
        setlocale(LC_MONETARY,"en_US.UTF-8");
        $value = money_format("%n", $value);
        return $value;
    }*/
    
    
    function user() {
        return $this->belongsTo('App\User');
    }

    public function trial(){
        return $this->belongsTo('App\Trial');
    }
}
