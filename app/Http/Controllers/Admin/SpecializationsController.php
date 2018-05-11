<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController as Controller;
use App\User;
use App\Specialization;
use Validator;

class SpecializationsController extends Controller
{
    
    
    
    
    function list_all() {
        
        $data['specializations'] = Specialization::all();
        return view('admin.specializations',$data);  
    }
    
    
    
    
    // inserts new specialization into database
    // request received from modal form
    // received ajax request
    function create(Request $request) {
        
        
        
        $validator = Validator::make($request->all(),[
            'name' => 'required'
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
    
    // load edit specialization view for admin level user
    function edit($id) {
        $data['specialization'] = Specialization::find($id);
        $data["clinics"] = $data["specialization"]->clinics;
        $data['users'] = User::where('user_type',"clinic")->get();
       return view('admin.specialization-edit',$data);
    }
    
    
    // update specialization
    function update(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
       
        $specialization = Specialization::find($request->id);
        $specialization->key = str_replace(" ","-",strtolower($request->name));
        $specialization->name = $request->name;
        $specialization->description = $request->description;
        $specialization->save();
    
        if($request->has('users') && count($request->users)){
            $specialization->users()->sync($request->users);
        }
        
        \Session::flash('message','Update successful!');
        return redirect()->back();
        
    }
    
}
