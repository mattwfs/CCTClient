<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Trial;
use App\User;
use App\Application;
use App\Specialization;

class SpecializationsController extends Controller
{
    function index($id)
    {

        $specialization_ids = [];
        $user = User::find(auth()->user()->id);
        //TODO: MATT- bounce if they don't have this specialization

        $final_trials=array();

        $trials = Trial::whereNull("deleted_at")
            ->orderBy('id','DESC')->get();

        foreach($trials as $trial){
            $trial_specializations = explode(",",$trial->specialization_id);
            foreach($trial_specializations as $trial_specialization){
                if($trial_specialization == $id){
                    $final_trials[]=$trial;
                }
            }
        }

        $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
        $data['trials'] = $final_trials;
        $data['specialization'] = $id;
        return view('users.opentrials',$data);
    }
}
