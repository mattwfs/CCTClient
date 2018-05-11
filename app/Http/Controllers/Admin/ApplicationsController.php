<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Trial;
use App\Question;
use App\Referral;
use App\Answer;
use App\Attachment;
use App\Conversation;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Hash;
use PDF;

class ApplicationsController extends Controller
{
    function index() {
    $data['applications'] = Application::where("deleted_at",null)
                                        ->orderBy('id','DESC')
                                        ->where("status","new")->get();

     return view('admin.new-applications',$data);
    }

    function all() {
        $data['applications'] = Application::where("deleted_at",null)
        ->orderBy('id','DESC')->get();
        return view('admin.all-applications',$data);
    }

    function processed() {
        $data['applications'] = Application::orderBy('id','DESC')
            ->whereNotIn('status', ["new","waitlist"])
            ->where("deleted_at",null)->get();

        return view('admin.processed-applications',$data);
    }
    function waitlist() {
        $data['applications'] = Application::orderBy('id','DESC')
            ->where("status","waitlist")
            ->where("deleted_at",null)->get();
        return view('admin.waitlist-applications',$data);
    }
    
    function applications_selected() {
        
        $data['applications'] = Application::orderBy('id','DESC')
                                        ->where("status","selected")
            ->where("deleted_at",null)->get();

        return view('admin.new-applications',$data); 
        
    }
    
    function applications_rejected() {
        
        $data['applications'] = Application::orderBy('id','DESC')
                                        ->where("status","rejected")
            ->where("deleted_at",null)->get();

        return view('admin.new-applications',$data); 
        
    }
    
    
    
    function trial($id) {
        $data['trial'] = Trial::find($id);
        $data['applications'] = Application::where('trial_id',$id)
                                ->orderBy('id','DESC')
                                ->whereNull("deleted_at")
                                ->get();
        
        return view('admin/applications',$data);
    }
    
    
    function single($id) {
        
        $app =Application::find($id);
        
        if($app->status =='new'){
            $app->status == 'review';
            $app->save();
        }
        
        $data['trial'] = Trial::find($app->trial->id);
        $data['questions'] = Question::where("trial_id",$data['trial']->id)->get();
        if(count($data['questions'])){
            $data['answers'] = Answer::where("application_id",$id)->get();
        }
        $data["conversation"] = Conversation::where("application_id",$id)->first();
        if($data["conversation"]){
            $data['messages'] = Message::where("conversation_id",$data["conversation"]->id)->get();
        } else {
            $data['messages'] = false;
        }

        $data['application'] = $app;

        return view('admin/application-single',$data);
    }
    
    
    
    function update_status(Request $request)
    {
        $application = Application::find($request->application_id);
        $application->status = $request->status;
        $application->save();
        
        
        $message = 'Your application for <b>"'.$application->trial->title.'"</b> was reviewed and admin has updated application status. Please login to your account to check the update.';
        send_notification($application->user_id,$message);
        
        
        $referral = Referral::where("email",$application->user->email)
                            ->where("trial_id",$application->trial->id)
                            ->where("status",'applied')
                            ->first();
        if($referral){
            $referral->application_status = $request->status;
            $referral->save();
            
            $message = 'Application for your referral '.$referral->name.' was updated by admin, please login into your account to check the update.';
            send_notification($referral->user_id,$message);
        }
        
        
        return 'success';
    }

    function update_note(Request $request)
    {
        $application = Application::find($request->application_id);
        $application->note = $request->note;
        $application->save();

        return 'success';
    }

    function download($id) {
        $application = Application::find($id);
        if(! $application) {
            dd('Application not found');
        }

        $data['answers'] = Answer::where("application_id",$id)->get();
        $data['application'] = $application;

        $pdf = PDF::loadView('pdf.application',$data);
        return $pdf->download('application.pdf');

        //return view('pdf/application',$data);
    }

    public function delete(Request $request) {

        $application = Application::find($request->delete_id);
        if($application){
            $admin = User::find(auth()->user()->id);
            $password = $request->admin_password;

            if(! Hash::check($request->admin_password,$admin->password)){
                echo '<p class="text-danger">Password is not correct</p>';
                die();
            }

            if(count($application->conversations)>0){
                foreach($application->conversations as $conversation){
                    $conversation->deleted_at = time();
                    $conversation->save();
                }
            }


            $application->deleted_at = time();
            $application->status = 0;
            $application->save();
            echo 'success';
            die();
        }

    }
}
