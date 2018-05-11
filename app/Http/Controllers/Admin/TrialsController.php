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
use App\Application;
use Illuminate\Support\Facades\Hash;

class TrialsController extends Controller
{
    public $trial_id;
    public $trial;
    
    public function list_all() {
        
        $data['trials'] = Trial::where("status",1)
                                ->where('deleted_at',null)
                                ->orderBy('id','DESC')->get();
        $data['users'] = User::where('user_type','clinic')
            ->where("deleted_at",null)
            ->orderBy("last_name","ASC")
            ->get();
        $data['specializations'] = Specialization::orderBy('name')->get();
        return view('admin.trials',$data);
    }
    
    
    
    public function edit($id) {
        $data['questions'] = Question::where("trial_id",$id)->get();
        $data['trial'] = Trial::find($id);
        $data['specializations'] = Specialization::orderBy('name')->get();
        $data['attachments'] = Attachment::where("attachable_id",$id)->where("attachable_type",'App\Trial')->whereNull("deleted_at")->get();
        $data["users"] = User::whereNull("deleted_at")->whereIn("user_type",["clinic","point_of_contact"])->orderBy("last_name","ASC")->get();
        return view('admin.trials-edit',$data);
            
    }
    
    
    public function update(Request $request) {
        $message = [
            'title.required'                => 'Title is required',
            'description.required'          => 'Description is required',
        ];
        $validator = Validator::make($request->all(),[
            'title'             => 'required',
            'description'       => 'required',
            'id'                => 'required|numeric'
        ],$message);
        
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $trial = Trial::find($request->id);
        $trial->title = $request->title;
        $trial->description = $request->description;
        $trial->source = $request->source;
        if($request->has('expires_on') && $request->expires_on != ''){
            $trial->expires_on = strtotime($request->expires_on);
        }
        else{
            $trial->expires_on = '';
        }
        $trial->specialization_id = implode(",",$request->specialization_id);
        
        if($request->has('requires_file')){
            $trial->requires_file = 1;
        } else {
            $trial->requires_file = 0;
        }
        if($request->has('no_waitlist')){
            $trial->no_waitlist = 1;
        }
        $trial->save();

        if($request->has("application_doctor")){
            foreach($request->application_doctor as $index=>$value){
                $application = new Application;
                $application->trial_id = $trial->id;
                $application->user_id = $value;
                $application->applied_as = 0;
                $application->status = $request->application_status[$index];
                $application->note = $request->application_note[$index];
                $application->save();

                $message = 'Your application for <b>"'.$application->trial->title.'"</b> was reviewed and admin has updated application status. Please login to your account to check the update.';
                send_notification($value,$message);
            }
        }

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

        if($request->hasFile('attachment')):
            $attachments = [];
            $i=1;

            $old_attachments = Attachment::where("attachable_id",$trial->id)->where("attachable_type",'App\Trial')->whereNull("deleted_at")->get();
            foreach($old_attachments as $old_attachment){
                $old_attachment->deleted_at = time();
                $old_attachment->save();
            }

            foreach($request->file('attachment') as $attachment):
                $ext = $attachment->getClientOriginalExtension();
                $name = time().'-'.$i.'.'.$ext;
                $attachment->move(base_path('uploads/'),$name);
                $att= new Attachment;
                $att->title = $attachment->getClientOriginalName();
                $att->file = $name;
                $att->attachable_id = $trial->id;
                $att->attachable_type = 'App\Trial';
                $att->save();
                $attachments[] = $att->id;
                $i++;
            endforeach;
            if(count($attachments)):
                $trial->attachments = serialize($attachments);
                $trial->save();
            endif;
        endif;

        \Session::flash('message','Update successful!');
        return redirect()->back();
        
    }
    
    
    
    public function create(Request $request) {
        //die();

        $message = [
            'title.required'                => 'Title is required',
            'description.required'          => 'Description is required',
            'specialization_id.required'    => 'Please select specialization group',
        ];
        $validator = Validator::make($request->all(),[
            'title'             => 'required',
            'description'       => 'required',
            'specialization_id' => 'required'
        ],$message);
        
        if($validator->fails()){
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }

        $trial = new Trial;
        $trial->title = $request->title;
        $trial->description = $request->description;
        $trial->source = $request->source;
        if($request->has('expires_on') && !empty($request->expires_on)) {
            $trial->expires_on = strtotime($request->expires_on);
        }
        if($request->has('requires_file')):
        $trial->requires_file = 1;
        endif;
        if($request->has('no_waitlist')):
            $trial->no_waitlist = 1;
        endif;
        $trial->specialization_id = implode(",",$request->specialization_id);
        $trial->save();
        $this->trial_id = $trial->id;
        $this->trial = $trial;

        if($request->has("application_doctor")){
            foreach($request->application_doctor as $index=>$value){
                $application = new Application;
                $application->trial_id = $this->trial_id;
                $application->user_id = $value;
                $application->applied_as = 0;
                $application->status = $request->application_status[$index];;
                $application->note = $request->application_note[$index];;
                $application->save();

                $message = 'Your application for <b>"'.$application->trial->title.'"</b> was reviewed and admin has updated application status. Please login to your account to check the update.';
                send_notification($value,$message);
            }
        }

        if($request->has('questionner')):
            $data = [];
            foreach($request->questionner as $questionner):
                [
                    'trial_id' => $this->trial_id,
                    'question' => $questionner['question'],
                    'status'    => 1
                ];
                $q = new Question;
                $q->trial_id = $this->trial_id;
                $q->question = $questionner['question'];
                $q->status = 1;
                $q->save();
                $data[] = $q->id;
            endforeach;
            if(count($data)):
                //$trial = Trial::find($this->trial_id);
                $trial->questions = serialize($data);
                $trial->save();
            endif;
        endif;

        if($request->hasFile('attachment')):
            $attachments = [];
            $i=1;
            foreach($request->file('attachment') as $attachment):
                $ext = $attachment->getClientOriginalExtension();
                $name = time().'-'.$i.'.'.$ext;
                $attachment->move(base_path('uploads/'),$name);
                    $att= new Attachment;
                    $att->title = $attachment->getClientOriginalName();
                    $att->file = $name;
                    $att->attachable_id = $this->trial_id;
                    $att->attachable_type = 'App\Trial';
                    $att->save();
                    $attachments[] = $att->id;
                $i++;
            endforeach;
            if(count($attachments)):
                $trial->attachments = serialize($attachments);
                $trial->save();
            endif;
        endif;



        $response['response_type'] = 'success';
        $response['message'] = 'Successfully Added';

        $current_trial = $trial;
        foreach($trial->specialization->users as $user) {
            
        $message = 'A new Study Trial was posted under <b>'.$trial->specialization->name.'</b><br/>';
        $message .= 'Please login to your account to apply.';
            send_notification($user->id,$message);
        }

        Session::flash('message','Trial Added');
        return redirect()->back();
        
    }

    public function create_historical(Request $request) {
        //die();

        $message = [
            'title.required'                => 'Title is required',
            'description.required'          => 'Description is required',
            'specialization_id.required'    => 'Please select specialization group',
        ];
        $validator = Validator::make($request->all(),[
            'title'             => 'required',
            'description'       => 'required',
            'specialization_id' => 'required'
        ],$message);

        if($validator->fails()){
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }

        $trial = new Trial;
        $trial->title = $request->title;
        $trial->description = $request->description;
        $trial->source = $request->source;
        if($request->has('expires_on') && !empty($request->expires_on)) {
            $trial->expires_on = strtotime($request->expires_on);
        }
        if($request->has('requires_file')):
            $trial->requires_file = 1;
        endif;
        if($request->has('no_waitlist')):
            $trial->no_waitlist = 1;
        endif;
        $trial->specialization_id = implode(",",$request->specialization_id);
        $trial->save();
        $this->trial_id = $trial->id;
        $this->trial = $trial;

        if($request->has("application_doctor")){
            foreach($request->application_doctor as $index=>$value){
                $application = new Application;
                $application->trial_id = $this->trial_id;
                $application->user_id = $value;
                $application->applied_as = 0;
                $application->status = $request->application_status[$index];;
                $application->note = $request->application_note[$index];;
                $application->save();

                $message = 'Your application for <b>"'.$application->trial->title.'"</b> was reviewed and admin has updated application status. Please login to your account to check the update.';
                send_notification($value,$message);
            }
        }

        if($request->has('questionner')):
            $data = [];
            foreach($request->questionner as $questionner):
                [
                    'trial_id' => $this->trial_id,
                    'question' => $questionner['question'],
                    'status'    => 1
                ];
                $q = new Question;
                $q->trial_id = $this->trial_id;
                $q->question = $questionner['question'];
                $q->status = 1;
                $q->save();
                $data[] = $q->id;
            endforeach;
            if(count($data)):
                //$trial = Trial::find($this->trial_id);
                $trial->questions = serialize($data);
                $trial->save();
            endif;
        endif;

        if($request->hasFile('attachment')):
            $attachments = [];
            $i=1;
            foreach($request->file('attachment') as $attachment):
                $ext = $attachment->getClientOriginalExtension();
                $name = time().'-'.$i.'.'.$ext;
                $attachment->move(base_path('uploads/'),$name);
                $att= new Attachment;
                $att->title = $attachment->getClientOriginalName();
                $att->file = $name;
                $att->attachable_id = $this->trial_id;
                $att->attachable_type = 'App\Trial';
                $att->save();
                $attachments[] = $att->id;
                $i++;
            endforeach;
            if(count($attachments)):
                $trial->attachments = serialize($attachments);
                $trial->save();
            endif;
        endif;



        $response['response_type'] = 'success';
        $response['message'] = 'Successfully Added';

        $current_trial = $trial;
        foreach($trial->specialization->users as $user) {

            $message = 'A new Study Trial was posted under <b>'.$trial->specialization->name.'</b><br/>';
            $message .= 'Please login to your account to apply.';
            send_notification($user->id,$message);
        }

        Session::flash('message','Trial Added');
        return redirect()->back();

    }

    public function delete(Request $request) {
        
        $trial = Trial::find($request->delete_id);
        if($trial){
            $admin = User::find(auth()->user()->id);
            $password = $request->admin_password;
            
            if(! Hash::check($request->admin_password,$admin->password)){
                echo '<p class="text-danger">Password is not correct</p>';
                die();
            }

            foreach($trial->applications as $application){
                $application->deleted_at = time();
                $application->save();
            }

            $trial->deleted_at = time();
            $trial->status = 0;
            $trial->save();
            echo 'success';
            die();    
        }
        
    }

    function add_question(Request $request) {
        $validator = Validator::make($request->all(),[
            'trial_id' => 'required|numeric',
            'new_question' => 'required',
        ]);
        
        if($validator->fails()){
            return redirect()->back->withErrors($validator);
        }
        
        $question = new Question;
        $question->status = 1;
        $question->trial_id = $request->trial_id;
        $question->question = $request->new_question;
        $question->save();
        
        Session::flash('message','New Feasibility Question added.');
        return redirect()->back();
    }
    
    
    
}