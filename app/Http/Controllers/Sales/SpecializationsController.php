<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trial;
use App\User;
use App\Application;
use App\Specialization;

class SpecializationsController extends Controller
{
    function index($id)
    {

        $specialization_ids = [];
        $specializations = [];
        $user = User::find(auth()->user()->id);

        foreach($user->clinics as $clinic){
            foreach($clinic->users as $doctor){
                foreach($doctor->specializations as $specialization){
                    array_push($specialization_ids,$specialization->id);
                    foreach($specializations as $final_specialization){
                        if($final_specialization->id == $specialization->id){
                            break 2;
                        }
                    }
                    array_push($specializations, $specialization);
                }
            }
        }

        $trials = \DB::table('trials')
            ->where('status','!=',0)->whereNull("deleted_at")
            ->orderBy('id','DESC')->get();

        $final_trials = array();

        foreach($trials as $trial){
            $trial_specializations = explode(",",$trial->specialization_id);
            foreach($trial_specializations as $trial_specialization){
                    if($trial_specialization == $id){
                        $final_trials[]=$trial;
                    }
            }
        }

        $data['specializations'] = $specializations;
        $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
        $data['trials'] = $final_trials;
        return view('sales.opentrials',$data);
    }
}
