<?php

namespace App\Http\Controllers\SalesManager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Specialization;
use App\Clinic;
use Validator;
use Hash;

class ClinicsController extends Controller
{
    
    // add user
    public function create(Request $request) {

        $rules = [
            'clinic_name' => 'required',
            'clinic_phone' => 'required',
            'clinic_address' => 'required',
            'clinic_city' => 'required',
            'clinic_state' => 'required',
            'clinic_zipcode' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }

        $clinic = new Clinic;
        $clinic->name    = $request->clinic_name;
        $clinic->email   = $request->clinic_email;
        $clinic->phone   = $request->clinic_phone;
        $clinic->address = $request->clinic_address;
        $clinic->state = $request->clinic_state;
        $clinic->city = $request->clinic_city;
        $clinic->postcode = $request->clinic_zipcode;
        $clinic->fax = $request->clinic_fax;
        $clinic->primary_location = 1;
        $clinic->sales_rep = auth()->user()->id;
        $clinic->save();




        
            $response['response_type'] = 'success';
            $response['message'] = 'Clinic successfully created.';
                echo json_encode(array_filter($response));  
    }
    
    
    
    
    
    
    // edit user
    public function edit($id) {

        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['states'] = get_states();
            $data['specializations'] = Specialization::all();
            return view('admin.user-edit',$data);
        }else{
            echo 'user not found';
        }
        
    }


    function clinic_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'    => 'required',
            'city'              => 'required',
            'postcode'          => 'required',
            'state'             => 'required',
            'phone'             => 'required|numeric',
            'practice_name'     => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $clinic = Clinic::find($request->clinic_id);
        $clinic->address = $request->address;
        $clinic->city = $request->city;
        $clinic->postcode = $request->postcode;
        $clinic->state = $request->state;
        $clinic->phone = $request->phone;
        $clinic->fax = $request->fax;
        $clinic->save();
        \Session::flash('message','Clinic Updated !');
        return redirect()->back();
    }
    
    
    
    //update user
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
        $user->role_id = $request->role_id;
        $user->is_active = $request->is_active;

        if($user->is_approved==0)

        $user->is_approved = $request->is_approved;



        if($request->role_id ==get_role_id('admin')) {
            $user->is_active = 2;
        }
        $user->is_partner = $request->is_partner;
        
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
        
        $message = 'Your account was updated by admin'; 
        //send_notification($user->id,$message);
        
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
        $user->role_id = 0;
        $user->is_complete = 0;
        $user->save();
            echo 'success';
            die();


        }
    }

    public function associate_clinic(Request $request){

        $clinic = Clinic::find($request->clinic_id);;
        if($clinic){
            $clinic->sales_rep = auth()->user()->id;
            $clinic->save();

            $response['response_type'] = 'success';
            $response['message'] = 'Clinic successfully added.';
            echo json_encode(array_filter($response));
        } else {
            $response['response_type'] = 'error';
            $response['message'] = 'Something went wrong.';
            echo json_encode(array_filter($response));
        }


    }
}
