<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Clinic;
use App\User;
use App\Trial;
use App\Specialization;
use Validator;
use Session;
use Hash;

class ClinicController extends Controller
{
    
    
    function users(){
        $data['specializations'] = Specialization::all();
        $data['states'] = get_states();
        $data['users'] = User::where('clinic_id',auth()->user()->clinic_id)
                                ->where('is_active','=','1')
                                ->where('id','!=',auth()->user()->id)
                                ->get();
        return view('clinic-admin.users',$data);
    }
    
    function user($id){
        $data['user'] = User::find($id);
        $data['specializations'] = $data['user']->specializations;
        $data['applications'] = $data['user']->applications;
        $data['referrals'] = $data['user']->referrals;
        $data['finances'] = $data['user']->finances;
        return view('clinic-admin.user',$data);
    }
    
    function add_user(){
        return view('clinic-admin.user-add');
    }
    
    function create_user(Request $request){
        $validator = Validator::make($request->all(),[
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email|unique:users'
        ],
        [
            'email.unique' => 'An account already exist with that email address'
        ]
        );
        
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->is_active = 1;
        $user->is_approved = 0;
        $user->is_complete = 1;
        $user->role_id = get_role_id('user');
        $user->clinic_id = auth()->user()->clinic_id;
        $user->user_type = 'doctor';
        $plain_password = str_random(6);
        $user->password = \Hash::make($plain_password);
        $user->save();
        
        $message = auth()->user()->clinic->name.' created an account for you. Please login to your account to manage.<br/><hr/>';  
        $message .= '<strong>Login details:</strong><br/><br/>';  
        $message .= 'Email: '.$user->email.'<br/>';  
        $message .= 'Password: '.$plain_password.'<br/>';  
        $message .= 'Please change this password, once you are logged in.';  
        send_notification($user->id,$message,1);
        
        Session::flash('message','User created');
        return redirect()->back();
    }

    public function user_edit($id) {

        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['states'] = get_states();
            $data['specializations'] = Specialization::all();
            return view('users.user-edit',$data);
        }else{
            echo 'user not found';
        }

    }

    public function update(Request $request) {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'specializations' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($request->id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->role_id = get_role_id("user");
        $user->is_active = $request->is_active;

        if($user->is_approved==0)

            $user->is_approved = $request->is_approved;



        if($request->role_id ==get_role_id('admin')) {
            $user->is_active = 2;
        }

        if($request->has('npi')):
            $user->npi = $request->npi;
        endif;


        if($request->has("new_password")){

            $plain_password = str_random(6);
            $user->password = \Hash::make($plain_password);

        }

        $user->save();

        $user->specializations()->sync($request->specializations);

        if($request->has("new_password")){

            $message = 'Your account login detail was automatically updated by system<br/><br/>';
            $message .= '<strong>Here are new login details :</strong><br/><br/>';
            $message .= 'Email: '.$user->email.'<br/>';
            $message .= 'Password: '.$plain_password.'<br/>';
            $message .= 'Please change this password, once you are logged in.';
            send_notification($user->id,$message);

        }

        \Session::flash('message','Update successfull!');
        return redirect()->back();

    }

    function delete(Request $request) {
        $user = User::find($request->delete_id);
        if($user){
            $admin = User::find(auth()->user()->id);
            $password = $request->admin_password;

            if(! Hash::check($request->admin_password,$admin->password)){
                echo '<p class="text-danger">Password is not correct</p>';
                die();
            }

            $user->deleted_at = time();
            $user->is_active = 0;
            $user->is_approved = 0;
            $user->role_id = 0;
            $user->is_complete = 0;
            $user->save();
            echo 'success';
            die();


        }
    }

    /*function update_user(Request $request){
        
    }
    
    function edit_user($id){
        return view('clinic-admin.user-edit');
    }*/
}
