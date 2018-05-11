<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Specialization;
use Validator;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    
    
   /*users*/ 
    public function users_list()
    {
        $data['users'] = User::where('role_id','!=',get_role_id('admin'))->get();
        $data['specializations'] = Specialization::all();
        return view('admin.users',$data);
    }
    
   public function get_user_ajax($id){
        
        $data =[];
        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['specializations'] = $user->specializations;
            return response()->json($data);
        }
        
    }
    
     
   public function edit_user($id){
        
        
        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['specializations'] = Specialization::all();
            return view('admin.edit_user',$data);
        }else{
            echo 'user not found';
        }
        
    }
    
    
    function edit_specialization($id){
       $data['specialization'] = Specialization::find($id);
       $data['users'] = User::where('role_id','!=',get_role_id('admin'))->get();
       return view('admin.edit_specialization',$data); 
    }
    
    
    
    
    public function add_user(Request $request){
        $update = false;
        if(isset($request->id)){
            $update = true;
        }
        
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'state' => 'required',
            'practise_name' => 'required',
            'role_id' => 'required',
            'is_partner' => 'required',
            
        ];
        
        if($update):
            $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'state' => 'required',
            'practise_name' => 'required',
            'role_id' => 'required',
            'is_active' => 'required',
            'is_partner' => 'required',
            
        ];
        endif;
        
        $validator = Validator::make($request->all(),$rules);
        
        if($validator->fails()){
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }
        
        
        if($update){
            $user = User::find($request->id);
        }
        else{
            $user = new User;
        }
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->street_address = $request->street_address;
        $user->city = $request->city;
        $user->postcode = $request->postcode;
        $user->state = $request->state;
        $user->practise_name = $request->practise_name;
        $user->role_id = $request->role_id;
        $user->is_active = $request->is_active;
        $user->is_partner = $request->is_partner;
        if(! $update):
            $user->is_active = 1;
            $plain_password = md5($request->email);
            $user->password = \Hash::make($plain_password);
        endif;
        $user->save();
        
        $response['response_type'] = 'success';
                $response['message'] = 'Account successfully created, please check your email for account activation';
                echo json_encode(array_filter($response));
                if($update){
                  $message = 'Your account was updated by admin';  
                }else{
                   $message = 'Your account was created<br/>';  
                   $message .= 'Login details:<br/>';  
                   $message .= 'Email:<br/>'.$user->email."<br/><br/>";
                   $message .= 'Password:<br/>'.$plain_password."<br/><br/>";
                   $message .= 'Please change this password, once you are logged in.';  
                }
                send_notification($user->id,$message);
                exit();
    }
    
    
    
    /*end users related*/
    
    
    
    
    
    /*specializations*/
    public function specializations_list()
    {
        $data['specializations'] = Specialization::all();
        return view('admin.specializations',$data);
    }
    
    
    public function get_specialization_ajax($id){
        
        $specializaton = Specialization::find($id);
        if($specializaton){
            return response()->json($specializaton);
        }
        
    }
    
    public function add_specialization_ajax(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required'
        ]);
        
        if($validator->fails()){
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }
        
         $specialization = new Specialization;
        if($request->id):
         $specialization = Specialization::find($request->id);
        endif;
       
        
        $specialization->key = str_replace(" ","-",strtolower($request->name));
        $specialization->name = $request->name;
        $specialization->description = $request->description;
        $specialization->save();
        $response['response_type'] = 'success';
        $response['message'] = 'Successfully Added';
        $response['redirect'] = url('admin/specializations');
        echo json_encode(array_filter($response));
        
    }
    
    /*end specialization related*/
    
    
    
    
    
    
    
    
    
    
    
   
    
}
