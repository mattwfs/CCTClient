<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use App\Specialization;
use App\Trial;
use App\Question;
use App\Attachment;
use App\User;

class AwardedController extends Controller
{


    
    public function list_all() {

        $data['trials'] = Trial::whereHas('applications', function ($query){
            $query->where("status","like","selected");
        })->get();

        return view('admin.awarded',$data);
    }
    
    
    
    public function edit($id) {
        $data['questions'] = Question::where("trial_id",$id)->get();
        $data['trial'] = Trial::find($id);
        $data['specializations'] = Specialization::all();
        return view('admin.trials-edit',$data);
            
    }
    
    
    public function update(Request $request) {
        $message = [
            'title.required'                => 'Title is required',
            'description.required'          => 'Description is required',
            'specialization_id.required'    => 'Please select specialization group',
            'specialization_id.numeric'     => 'Invalid specialization selection'
        ];
        $validator = Validator::make($request->all(),[
            'title'             => 'required',
            'description'       => 'required',
            'specialization_id' => 'required|numeric',
            'id'                => 'required|numeric'
        ],$message);
        
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $trial = Trial::find($request->id);
        $trial->title = $request->title;
        $trial->description = $request->description;
        if($request->has('expires_on') && $request->expires_on != ''){
            $trial->expires_on = strtotime($request->expires_on);
        }
        else{
            $trial->expires_on = '';
        }
        $trial->specialization_id = $request->specialization_id;
        
        if($request->has('requires_file')){
            $trial->requires_file = 1;
        }
        $trial->save();
        
        
        if($request->has('questions')){
            
            foreach($request->questions as $id => $question){
                $q = Question::find($id);
                if($q){
                    
                    $q->question = $question;
                    $q->save();
                }else{
                    continue;
                }
            }
        }
        
        \Session::flash('message','Update successful!');
        return redirect()->back();
        
    }

}