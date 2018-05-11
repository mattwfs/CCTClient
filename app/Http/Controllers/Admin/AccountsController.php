<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController as Controller;
use Auth;
use App\User;
use App\Trial;
use App\Application;
use App\Specialization;
use App\Clinic;
use Validator;

class AccountsController extends Controller
{
    
        
     public function dashboard()
        {
            $data["trials"] = Trial::whereNull("deleted_at")->get();
            $data["submissions"] = Application::whereNull("deleted_at")->get();
            $data["sivs"] = Application::where("status","pending_siv")->whereNull("deleted_at")->get();
            $data["psvs"] = Application::where("status","pending_psv")->whereNull("deleted_at")->get();
            $data["awarded"] = Application::where("status","awarded")->whereNull("deleted_at")->get();
            $data["not_awarded"] = Application::where("status","!=","awarded")->whereNull("deleted_at")->get();
            $data["site_declined"] = Application::where("status","sponsor_declined")->whereNull("deleted_at")->get();
            $data["sites"] = Clinic::whereNull("deleted_at")->get();
            $data["users"] = User::whereNull("deleted_at")->get();
        return view('admin.dashboard',$data);
    }   
        
    // load login page for admin
    function login() {
        return view('admin.login'); 
    }
    
        
          
    // signin admin users
    function signin(Request $request) {

            $data['errors'] =[];
            $messages =[
                        'email.email' => 'Thats not a valid email.',
                        'email.required' => 'Hey, we need your email address.',
                        'password.required' => 'Password is required',
                ];
        
               $validator = Validator::make($request->all(), [
                    'email' => 'email|required',
                    'password' => 'required',
                ],$messages);
                
                if($validator->fails()){
                        return redirect()->back()->withErrors($validator)->withInput();
                }
        
                $expected_sum = $request->val1+$request->val2;
                if($expected_sum != $request->sum){
                        $data['errors'][] = 'You entered the incorrect number.';
                }
                if($request->username !=''){
                       $data['errors'][] = 'You don&apos;t seem to be human.'; 
                }
            
                if(count($data['errors'])){
                        return redirect()->back()->withErrors($data);
                }
                
                
                
                
                $login_details = [
                        'email' => $request->email,
                        'password' => $request->password,
                        'is_active' => 2,
                        'role_id' => get_role_id('admin'),
                ];
        
                if(Auth::attempt($login_details)){
                        return redirect('admin');
                }else{
                        return 'Invalid Email or password';
                }
        
    }
    
    // create new admin users
    function create() {
        
        
    }
    
}
