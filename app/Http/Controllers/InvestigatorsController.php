<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Investigator;
use Validator;
use Session;

class InvestigatorsController extends Controller
{
    function index() {
        return view('users.investigators');
    }
    
    
    
    function create(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        
        $investigator = new Investigator;
        $investigator->name = $request->name;
        $investigator->user_id = auth()->user()->id;
        $investigator->license = $request->license;
        $investigator->license_expiry = $request->license_expiry;
        $investigator->save();
        Session::flash('message','Investigator created');
        return redirect()->back();
    }
    
    
    
    function update(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'id'    => 'required|numeric'
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        
        $investigator = Investigator::where("id",$request->id)
                                        ->where("user_id",auth()->user()->id)
                                        ->first();
        if(! $investigator){
            $errors[] = 'Investigator does not exist.';
            return redirect()->back()->withErrors($errors);
        }
        $investigator->name = $request->name;
        $investigator->license = $request->license;
        $investigator->license_expiry = $request->license_expiry;
        $investigator->save();
        Session::flash('message','Investigator updated');
        return redirect()->back();
    }
}
