<?php

namespace App\Http\Controllers\SalesManager;

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


            $clinic_count = 0;
            foreach(auth()->user()->sales_reps as $rep){
                $rep_clinics = Clinic::where('sales_rep',$rep->id)->get();
                $clinic_count += count($rep_clinics);
            }

            $data["clinics"]= $clinic_count;
        $users = [];
        $user = User::find(auth()->user()->id);

        foreach($user->clinics as $clinic){
            foreach($clinic->users as $doctor){
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
        return view('sales-manager.dashboard',$data);
    }
    
    
    function clinic($id){
        $data['clinic'] = Clinic::find($id);
        $data['applications'] = Application::where("clinic_id",$id);
        $data['states'] = get_states();
        $data['specializations'] = Specialization::all();
        if($data['clinic']){
            $data['users'] = User::where('clinic_id',$id)->get();
            return view('sales.users',$data);
        }
    }

    function clinics(){
        $data["all_clinics"] = Clinic::all();
        $sales_manager = User::find(auth()->user()->id);
        $data['sales_reps'] = $sales_manager->sales_reps;
        $data['clinics'] = Clinic::where('sales_rep',auth()->user()->id)->get();
        return view('sales-manager.clinics',$data);
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
        foreach($user->sales_reps as $rep){
            foreach($rep->clinics as $clinic){
                foreach($clinic->users as $doctor){
                    foreach($doctor->specializations as $specialization){
                        if(!in_array($specialization->id, $specialization_ids)){
                            array_push($specialization_ids,$specialization->id);
                            array_push($specializations, $specialization);
                        }
                    }
                }
            }
        }
        $count_specialization = count(array_unique($specialization_ids));
        if($count_specialization == 1){
            $trials = Trial::where('specialization_id','=',$specialization_ids[0])
                ->orderBy('id','DESC')
                ->get();
        }
        else {
            $trials = \DB::table('trials')
                ->whereIn('specialization_id',$specialization_ids)
                ->where('status','!=',0)
                ->where('expires_on','=','')
                ->orWhere('expires_on','>=',time())
                ->orderBy('id','DESC')
                ->paginate(15);
        }

        $data['specializations'] = array_unique($specializations);
        $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
        $data['trials'] = $trials;
        return view('sales.opentrials',$data);
    }
}
