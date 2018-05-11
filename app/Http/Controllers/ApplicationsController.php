<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Application;
use App\Attachment;
use App\Conversation;
use App\Question;
use App\Referral;
use App\Trial;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use PDF;

class ApplicationsController extends Controller
{
    public function apply(Request $request) {
        if(!$request->investigator){
            dd('Please go back and select an investigator');
        }
        if(can_apply($request->trial) && ! has_applied($request->investigator,$request->trial)):
        $data['trial'] = Trial::find($request->trial);
        $data['investigator'] = '';
        if($request->investigator){
          $data['investigator'] = User::find($request->investigator);
        }
        $data['questions'] = Question::where("trial_id",$request->trial)->get();
        $data['user'] = User::find(auth()->user()->id);
        return view('users.apply',$data);
        else:
        dd('You can not apply for this trial');
        endif;
    }
    
    
    
    
    public function applications() {
        $data['applications'] = Application::where("user_id",auth()->user()->id)->where("deleted_at",null)
                                ->orderBy('id','DESC')
                                ->paginate(10);

        $data['applications']->setPath(url('user/my-applications/'));
        return view('users.my-applications',$data);
    }
    
    
    
    function post_applications(Request $request) {
        
        $trial_id = $request->trial_id;
        $user_id = auth()->user()->id;
        
        
        $application = new Application;
        if($request->has('signature_data')){
            $application->signature = $request->signature_data;
        }
        $application->trial_id = $trial_id;
        $application->user_id = $user_id;
        if(auth()->user()->is_partner==1){
            $application->applied_as = 1;
        }else{
            $application->applied_as = 0;
        }
        
        if($request->investigator_id != 0){
            $application->investigator_id = $request->investigator_id;
        }
        
        $application->save();
        
        
        // answers for the trial questions
        if($request->has('answer')):
            foreach($request->answer as $key => $value):
        
                $answer = new Answer;
                $answer->question_id = $key;
                $answer->user_id = $user_id;
                $answer->trial_id = $trial_id;
                $answer->application_id = $application->id;
                $answer->answer = $value;
                $answer->save();
        
            endforeach;
        endif;
        
        
        // only if user is a broker
        if($request->has('broker_agreement')):
        
        endif;
        
        // file upload
        if($request->hasFile('application_attachment')):
        
            $attachments = [];
            $i=1;
            foreach($request->file('application_attachment') as $attachment):
                $ext = $attachment->getClientOriginalExtension();
                $name = time().'-'.$i.'.'.$ext;
                $attachment->move(base_path('uploads/'),$name);
                    $att= new Attachment;
                    $att->title = $attachment->getClientOriginalName();
                    $att->file = $name;
                    $att->attachable_id = $application->id;
                    $att->attachable_type = 'App\Application';
                    $att->save();
                    $attachments[] = $att->id;
                $i++;
            endforeach;
        
                if(count($attachments)){
                    $application->attachment = serialize($attachments);
                    $application->save();
                }
        
        endif;
        
        $referral = Referral::where("email",auth()->user()->email)
                            ->where("trial_id",$request->trial_id)
                            ->first();
        if($referral){
            $referral->status = 'applied';
            $referral->save();
        }
        
        return view('users.application-sent');
        
    }
    
    
    
    function download($id) {
        $application = Application::find($id);
        if(! $application) {
            dd('Application not found');
        }
        
        if($application->user_id  != auth()->user()->id) {
            return redirect(url('not-authorized'));
        }
        $data['answers'] = Answer::where("application_id",$id)->get();
        $data['application'] = $application;
        
        $pdf = PDF::loadView('pdf.application',$data);
        return $pdf->download('application.pdf');
        
        //return view('pdf/application',$data);
    }
    
    
    
    function has_applied(Request $request){
        
        $user_id = $request->user_id;
        $trial_id = $request->trial_id;
        $investigator_id = $request->investigator_id;
        
        if($request->investigator_id==0){
            $investigator_id = null;
        }
        
        $application = Application::where("trial_id",$trial_id)
                                    ->where("investigator_id",$investigator_id)
                                    ->where("user_id",$user_id)
                                    ->whereNull("deleted_at")
                                    ->count();
        
        return $application;
                                    
        
    }
    
    
    function single($id) {
        
        $app =Application::find($id);
        
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

        return view('users/application-single',$data);
    }
}
