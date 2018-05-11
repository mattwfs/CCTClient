<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Reminder;

class RemindersController extends Controller
{
    function set_reminder(Request $request) {
        
        if(can_set_reminder($request->trial_id)){
               $validator= Validator::make($request->all(),[
                   'remind_after' => 'required|numeric',
                   'trial_id'     => 'required|numeric'
               ]);
            
                if($validator->fails()) {
                    $response['response_type'] = 'error';
                    $response['message'] = $validator->errors();
                    echo json_encode(array_filter($response));
                    die();
                }
            
            $reminder = new Reminder;
            $reminder->user_id = auth()->user()->id;
            $reminder->trial_id = $request->trial_id;
            $rem_time = '+'.$request->remind_after.' hours';
            $reminder->reminder_time = strtotime($rem_time);
            $reminder->save();
            
            $response['response_type'] = 'success';
            $response['message'] = 'You will receive a reminder email and text';
            echo json_encode(array_filter($response));
            die();
         }
        
    }
}
