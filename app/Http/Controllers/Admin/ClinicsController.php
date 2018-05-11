<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController as Controller;
use App\User;
use App\Specialization;
use App\Clinic;
use App\Location;
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
        $clinic->save();




        
            $response['response_type'] = 'success';
            $response['message'] = 'Clinic successfully created.';
                echo json_encode(array_filter($response));  
    }

    public function location_create(Request $request) {

        $rules = [
            'location_phone' => 'required',
            'location_address' => 'required',
            'location_city' => 'required',
            'location_state' => 'required',
            'location_zipcode' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $location = new Location;
        $location->phone   = $request->location_phone;
        $location->address = $request->location_address;
        $location->state = $request->location_state;
        $location->city = $request->location_city;
        $location->postcode = $request->location_zipcode;
        $location->fax = $request->location_fax;
        $location->clinic_id = $request->clinic_id;
        $location->save();

        \Session::flash('message','Location Updated !');
        return redirect()->back();
    }

    
    
    
    
    // edit user
    public function edit($id) {

        $clinic = Clinic::find($id);
        if($clinic){
            $data['clinic'] = $clinic;
            $data['states'] = get_states();
            $data['specializations'] = Specialization::all();
            return view('admin.clinic-edit',$data);
        }else{
            echo 'user not found';
        }
        
    }
    
    //update user
    function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'address'    => 'required',
            'city'              => 'required',
            'postcode'          => 'required',
            'state'             => 'required',
            'phone'             => 'required',
            'practice_name'     => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }


        $clinic = Clinic::find($request->clinic_id);
        $clinic->name = $request->practice_name;
        $clinic->address = $request->address;
        $clinic->city = $request->city;
        $clinic->postcode = $request->postcode;
        $clinic->state = $request->state;
        $clinic->phone = $request->phone;
        $clinic->fax = $request->fax;
        $clinic->is_approved = $request->is_approved;
        $clinic->is_active = $request->is_active;
        if($request->has('specializations')) {
            $clinic->specializations()->sync($request->specializations);
        }

        $clinic->save();
        \Session::flash('message','Clinic Updated !');
        return redirect()->back();
    }
    

    function delete(Request $request) {
        $clinic = Clinic::find($request->delete_id);
        if($clinic){
            $admin = User::find(auth()->user()->id);
            $password = $request->admin_password;
            
            if(! Hash::check($request->admin_password,$admin->password)){
                echo '<p class="text-danger">Password is not correct</p>';
                die();
            }

            $clinic->deleted_at = time();
            $clinic->is_active = 0;
            $clinic->is_approved = 0;
            $clinic->sales_rep="";

            foreach($clinic->users as $user){
                $user->deleted_at = time();
                $user->is_active = 0;
                $user->role_id = 0;
                $user->user_type = null;
                $user->is_approved = 0;
                $user->email = "";
                $user->save();
            }
            $clinic->save();
            echo 'success';
            die();
            
            
        }
    }

    function location_delete(Request $request) {
        $clinic = Location::find($request->delete_id);
        if($clinic){
            $admin = User::find(auth()->user()->id);
            $password = $request->admin_password;

            if(! Hash::check($request->admin_password,$admin->password)){
                echo '<p class="text-danger">Password is not correct</p>';
                die();
            }

            $clinic->deleted_at = time();

            foreach($clinic->users as $user){
                $user->location_id = null;
                $user->save();
            }
            $clinic->save();
            echo 'success';
            die();


        }
    }

}
