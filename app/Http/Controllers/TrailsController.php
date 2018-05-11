<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Specialization;
use App\Trial;
use App\Attachment;

class TrailsController extends Controller
{
    
    public function index($id,$waitlist=0) {
        $data['trial'] = Trial::find($id);
        if($waitlist){
            $data["waitlist"]=true;
        } else {
            $data["waitlist"]=false;
        }

        if($data['trial']){
            $data['attachments'] = Attachment::where("attachable_id",$data['trial']->id)->where("attachable_type",'App\Trial')->whereNull("deleted_at")->get();
            return view('users.single-trial',$data);
        }
        else{
            dd('Trial doesnot exist.');
        }
        
    }
    
    
    
    // called by ajax in interval
    public function get_latest_ajax()
    {
        $specialization_ids = [];
        $user = User::find(auth()->user()->id);
        $specializations = $user->specializations;
        if($specializations):
        
            foreach($specializations as $specialization){
                array_push($specialization_ids,$specialization->id);
            }
        
            $count_specialization = count($specialization_ids);
            if($count_specialization == 1){
                $trials = Trial::where('specialization_id','=',$specialization_ids[0])
                                ->where('status','!=',0)
                                ->where('deleted_at',null)
                                ->where('expires_on','=','')
                                ->orWhere('expires_on','>=',time())
                                ->orderBy('id','DESC')
                                ->get();
            }
            else {
                $trials = \DB::table('trials')
                            ->whereIn('specialization_id',$specialization_ids)
                            ->where('status','!=',0)
                            ->where('deleted_at',null)
                            ->where('expires_on','=','')
                            ->orWhere('expires_on','>=',time())
                            ->orderBy('id','DESC')
                            ->get();
            }
            //print_r($specialization_ids);
            
            $html = '<ul class="trials-list">';
            foreach($trials as $trial){
                
                $html .= '<li class="trial-update">';
                $html .= '<a class="trial-update-link" href="'.url('user/trial/'.$trial->id).'">';
                $html .= $trial->title;
                $html .= '</a>';
                $html .= '</li>'; 
            }
            $html .= '</ul>';
            echo $html;
        
        endif;
        
        //$trials = Trial::where('specialization_id','=',)->get();
        
    }
}
