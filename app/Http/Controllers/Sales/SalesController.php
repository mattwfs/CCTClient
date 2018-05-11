<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Clinic;
use App\User;
use App\Trial;
use App\Application;
use App\Specialization;

class SalesController extends Controller
{
    function index(){
        $finances = [];

        $trials = [];
        $submissions = [];
        $sivs = [];
        $psvs = [];
        $awarded = [];
        $not_awarded = [];
        $site_declined = [];
        $sites=[];
        $users = [];

        $user = User::find(auth()->user()->id);

        foreach($user->clinics as $clinic){
            array_push($sites,$clinic);
            foreach($clinic->users as $doctor){
                    foreach($doctor->applications as $application){
                        array_push($submissions, $application);
                        if($application->status == "pending_siv"){
                            array_push($sivs, $application);
                        } else if($application->status == "pending_psv"){
                            array_push($psvs, $application);
                        } else if($application->status == "awarded"){
                            array_push($awarded, $application);
                        } else if($application->status == "sponsor_declined"){
                            array_push($not_awarded, $application);
                        } else if($application->status == "site_declined"){
                            array_push($site_declined, $application);
                        }

                    }
                    array_push($users, $doctor->id);
                    foreach($doctor->finances as $finance){
                        if(!array_key_exists($finance->trial->id,$finances)){
                            $finances[$finance->trial->id] = $finance->earnings_amount;
                        } else {
                            $finances[$finance->trial->id] += $finance->earnings_amount;
                        }
                    }
            }
        }

        $data["finances"] = $finances;
        $data['applications'] = Application::whereIn("user_id",$users)->where("status","=","selected")->get();

        $data["trials"] = Trial::whereNull("deleted_at")->get();
        $data["submissions"] = $submissions;
        $data["sivs"] = $sivs;
        $data["psvs"] = $psvs;
        $data["awarded"] = $awarded;
        $data["not_awarded"] = $not_awarded;
        $data["site_declined"] = $site_declined;
        $data["sites"] = $sites;
        $data["users"] = $users;


        return view('sales.dashboard',$data);
    }
    
    
    function clinic($id){
        $data['clinic'] = Clinic::find($id);
        $data['applications'] = Application::where("clinic_id",$id)->whereNull("deleted_at");
        $data['states'] = get_states();
        $data['specializations'] = Specialization::all();
        if($data['clinic'] && $data['clinic']->sales_rep == auth()->user()->id){
            $data['users'] = User::where('clinic_id',$id)->where("deleted_at",null)->get();

            $applications = array();
            foreach($data['users'] as $user){
                foreach($user->applications as $application){
                    if(is_null($application->deleted_at))
                    $applications[] = $application;
                }
            }
            $data["applications"] = $applications;

            return view('sales.users',$data);
        }
    }

    function clinics(){
        $data["all_clinics"] = Clinic::all();
        $clinics = Clinic::where('sales_rep',auth()->user()->id)->where("deleted_at",null)->get();
        foreach($clinics as $index=>$clinic){
            $applications = array();
            foreach($clinic->users as $user){
                foreach($user->applications as $application){
                    $applications[] = $application;
                }
            }

            $clinics[$index]->applications = $applications;
        }
        $data['clinics'] = $clinics;
        return view('sales.clinics',$data);
    }

    function finances(){
            $finances = [];
            $user = User::find(auth()->user()->id);

            foreach($user->clinics as $clinic){
                foreach($clinic->users as $doctor){
                    foreach($doctor->finances as $finance){
                        array_push($finances,$finance);
                    }
                }
            }

            $data['finances'] = $finances;
            return view('sales.finances.finances-list',$data);
    }

    public function opentrials() {

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
                foreach(array_unique($specialization_ids) as $id){

                    if($trial_specialization == $id){
                        foreach($final_trials as $final_trial){
                            if($final_trial->id == $trial->id){
                                break 2;
                            }
                        }
                        $final_trials[]=$trial;
                    }
                }
            }
        }

        $data['specializations'] = $specializations;
        $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
        $data['trials'] = $final_trials;
        return view('sales.opentrials',$data);
    }
}
