<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Http\Controllers\Controller;
use App\Trial;
use App\Attachment;

class TrailsController extends Controller
{
    
    public function index($id) {
        $data['trial'] = Trial::find($id);

        if($data['trial']){
            $data['attachments'] = Attachment::where("attachable_id",$data['trial']->id)->where("attachable_type",'App\Trial')->get();
            return view('sales.single-trial',$data);
        }



        else{
            dd('Trial doesn\'t exist.');
        }
        
    }

}
