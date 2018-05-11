<?php
function get_role_id($key)
{
        $role = App\Role::where("key",$key)->first();
        if($role){
             return $role->id;
        }
        return 0;
}


function get_referred_trial($user_id){
        
        $referred_by = is_referral($user_id);
        if($referred_by){
                $user = App\User::find($user_id);
                $ref = App\Referral::where("user_id",$referred_by)
                                ->where("email",$user->email)
                                ->where("status","!=","applied")
                                ->first();
                if($ref){
                    return $ref->trial_id;
                }
        }
        
        return false;
}


function get_role_key($role_id)
{
       $role = App\Role::find($role_id);
        return $role->key;
}


function get_dashboard_url(){

        if(auth()->user())
        {

             $role = get_role_key(auth()->user()->role_id);
                $url = url('/');
                $url .='/';
                if(auth()->user()->role_id== get_role_id('sales_rep')){
                        $url .= 'rep';
                }else{
                        $url .= $role;
                }
                return $url;
        }
        return '#';
}



function send_notification($user_id,$message_body,$bcc = 0){
        
        $user = App\User::findOrFail($user_id);
        if($user):
                $logo = asset('assets/images/logo.png');
                $name =  ucfirst($user->first_name).' '.ucfirst($user->last_name);
        
                \Mail::send('emails.notification', ['name' => $name,'message_body'=>$message_body,'logo'=>$logo], function ($m) use ($user,$bcc) {
                    $m->from('hello@email.cctclient.com', 'Conduct Clinical Trials');
                    $m->to($user->email, $user->first_name.' '.$user->last_name)->subject('Notification');
                    if($bcc){
                        $m->bcc(["shilo@conductclinicaltrials.com","hello@cctclient.com"]);
                    }
                });
        endif;
        
}



function send_password_reset_link($user_id,$link){
        
                $user = App\User::findOrFail($user_id);
                $logo = asset('assets/images/logo.png');
                \Mail::send('emails.password_reset', ['user' => $user,'link'=>$link,'logo'=>$logo], function ($m) use ($user) {
                    $m->from('hello@cctclient.com', 'Conduct Clinical Trials');
                    $m->to($user->email, $user->first_name.' '.$user->last_name)->subject('Notification');
                });
        
}



function get_latest_update() {
        
        $user_id = auth()->user()->id;
        $specializations = auth()->user()->specialization;
        
}


function can_set_reminder($trial_id) {
        
        if(! can_apply($trial_id)){
                return false;
        }
        
        $reminder = App\Reminder::where("user_id",auth()->user()->id)
                                ->where("trial_id",$trial_id)
                                ->where("status",0)
                                ->first();
        
        if($reminder){
                return false;
        }
        
        return true;
}

function can_apply($trial_id) {
        $arr = [];
        $trial = App\Trial::find($trial_id);
        $user = App\User::find(auth()->user()->id);
        $specializations = $user->specializations;
        
        foreach($specializations as $s):
                array_push($arr,$s->id);
        endforeach;

        foreach($user->applications as $application){
            if($application->trial_id == $trial_id){
                return false;
            }
        }

        if($trial->deleted_at):
                return false;
        endif;

        if(! $trial->status):
                return false;
        endif;

        if($trial->expires_on):
                if($trial->expires_on <= time()):
                    if($trial->no_waitlist==0){
                        return true;
                    } else {
                        return false;
                    }
                endif;
        endif;

        if(! $specializations):
                return false;
        elseif($trial->status !=1):
                return false;
        else:
            foreach(explode(",",$trial->specialization_id) as $specialization){
                foreach($arr as $user_specialization){
                    if($user_specialization == $specialization){
                        return true;
                    }
                }
            }

            return false;
        endif;
        
        return true;
}



function get_new_message_count() {
        $messages = App\Message::where("user_id",auth()->user()->id)
                                ->where("status","new")
                                ->get();
       return count($messages);
        
}

function get_new_application_count() {
    $messages = App\Application::where("status","new")->whereNull("deleted_at")
        ->get();
    return count($messages);

}

function get_new_referral_count() {
    $referrals = App\Referral::where("status","new")->whereNull("deleted_at")
        ->get();
    return count($referrals);

}


function can_referr($trial_id) {
        $trial = App\Trial::find($trial_id);
        
        if(! $trial->status):
                return false;
        endif;
        
        if($trial->deleted_at):
                return false;
        endif;
        
        if($trial->expires_on):
                if($trial->expires_on <= time()):
                        return false;
                endif;
        endif;
        
        return true;
}


function send_referral_email($id) {
        $re = App\Referral::find($id);
        $referred_by = ucfirst($re->user->first_name).' '.ucfirst($re->user->last_name);
        $email = $re->email;
        $name = $re->name;
        $trial_name = $re->trial->title;
        //$logo = asset('assets/images/logo.png');


        \Mail::send('emails.referral', ['name' => $name,'trial'=>$trial_name, 'referred_by'=> $referred_by ], function($m) use ($email,$name) {
            $m->from('hello@cctclient.com', 'Conduct Clinical Trials');
            $m->bcc('info@conductclinicaltrials.com', 'Conduct Clinical Trials');
            $m->bcc('lawgiver00@gmail.com', 'Conduct Clinical Trials');
            $m->to($email,$name)->subject('Referral');
        });
}


function send_generic_referral_email($id) {
    $re = App\Referral::find($id);
    $referred_by = ucfirst($re->user->first_name).' '.ucfirst($re->user->last_name);
    $email = $re->email;
    $name = $re->name;


    \Mail::send('emails.referral-generic', ['name' => $name, 'referred_by'=> $referred_by ], function($m) use ($email,$name) {
        $m->from('hello@cctclient.com', 'Conduct Clinical Trials');
        $m->bcc('info@conductclinicaltrials.com', 'Conduct Clinical Trials');
        $m->bcc('lawgiver00@gmail.com', 'Conduct Clinical Trials');
        $m->to($email,$name)->subject('Referral');
    });
}


function delete_reminder($id) {
        
        $reminder = App\Reminder::find($id);
        if($reminder) {
                $reminder->delete();
        }
}



function get_timezones(){
        return [
          'est' => 'EST',      
          'cst' => 'CST',      
          'mst' => 'MST',      
          'pst' => 'PST',      
        ];
}

//'new','selected','rejected','review','delayed','pending_sponsor_approval','sponsor_declined','md_declined','delayed'
function get_application_status_list() {
        return [
                'new' => 'No Action',
                'review' => 'Under Review',
                'selected' => 'Awarded Study',
                'delayed' => 'Delayed',
                'pending_sponsor_approval' => 'Pending Sponsor Approval',
                'pending_psv' => 'Pending PSV',
                'pending_siv' => 'Pending SIV',
                'sponsor_declined' => 'Sponsor Declined',
                'md_declined' => 'MD Declined',
                'pending_documents_from_site' => 'Pending Documents From Site'
        ];
}


function get_referral_application_count($email) {
        $ref = App\Referral::where("email",$email)->first();
        
        if($ref){
                $user = App\User::where("email",$email)->first();
                if($user) {
                        return App\Application::where("user_id",$user->id)->count();
                }
        }
        return false;
}

function get_referred_account_count($user_id,$account= true) {
        $count = 0;
        $ref = App\Referral::where("user_id",$user_id)->get();
        if($account == false){
                return count($ref);
        }
        foreach($ref as $r){
             $email = $r->email;
                $user = App\User::where("email",$email)->first();
                if($user){
                        $count = $count+1;
                }
        }
        return $count;
}

function referred_by($user_id,$name=true) {
        $user = App\User::find($user_id);
        if($user->referred_by){
                
                $referred_by = App\User::find($user->referred_by);
                
                if($name == true)
                {
        return ucfirst($referred_by->first_name).' '.ucfirst($referred_by->last_name);
                }
                else
                {
                  return $referred_by->id;      
                } 
        }
        return false;
}


function get_user_id($email) {
        
        $user = App\User::where("email",$email)->first();
        if($user){
                return $user->id;
        }
        
        return false;
}


function get_option($key) {
        $option = App\Option::where("option_key",$key)->first();
        if($option){
                return $option->option_value;
        }
        return false;
}

function call_me_back($user_id) {
        $user = App\User::find($user_id);
        $admin_email =get_option('admin_email');
        $user_name = ucfirst($user->first_name).' '.ucfirst($user->last_name);
        $user_email = $user->email;
        $user_phone = $user->phone;
        $user_profile = url('admin/user/'.$user->id);
        
        $message = 'Hello Admin,<br/><br/>';
        $message .= 'A user on your website has requested you to call back. Here are the detials for the user:<br/><br/>';
        $message .= '<p><strong>'.$user_name.'</strong></p>';
        $message .= '<p><strong>Email : '.$user_email.'</strong></p>';
        $message .= '<p><strong>Phone : '.$user_phone.'</strong></p>';
        $message .= '<p><strong>Profile : '.$user_profile.'</strong></p>';
        
        
\Mail::send('emails.call-back', ['message_body'=>$message], function ($m) use ($admin_email) {
                    $m->from($admin_email, 'Conduct Clinical Trials');
                    $m->to($admin_email,'Conduct Clinical Trials')->subject('Call Back Request');
                });
        
}





function mark_message_old($id) {
        $message = App\Message::where("id",$id)
                                ->where("status","new")
                                ->where("user_id",auth()->user()->id)
                                ->first();
        if($message){
                $message->status = 'old';
                $message->save();
        }
}



function get_user_name($id) {
        $user = App\User::find($id);
        return ucfirst($user->first_name).' '.ucfirst($user->last_name);
}


function convo_has_new_messages($conversation_id,$user_id){
        
        $messages = App\Message::where("conversation_id",$conversation_id)
                                ->where("msg_from",$user_id)
                                ->where("status",'new')
                                ->count();
        if($messages){
                return $messages;
        }
        
        return null;
}


function get_investigators_list($clinic_id = ''){

        if($clinic_id == ''){
            $clinic_id = auth()->user()->clinic_id;
        }

    //@TODO: MATT you remove point_of_contact becuase point_of_contacts shouldn't be able to select themselves
    $investigators =   App\User::where("clinic_id",$clinic_id)->where("role_id",2)->where("user_type","clinic")->get();

    if(! count($investigators)){
                return null;
        }
        
        return $investigators;
}




function has_applied($investigator_id,$trial_id){
      if($investigator_id == 0){
              $investigator_id = null;
      } 
        $user_id = auth()->user()->id;
        
        $application = App\Application::where("trial_id",$trial_id)
                                    ->where("investigator_id",$investigator_id)
                                    ->where("user_id",$user_id)->whereNull("deleted_at")
                                    ->count();
        
        return $application;
}


function investigator_name($id){
        $inv = App\User::find($id);
        if($inv){
                return ucfirst($inv->first_name). " ".ucfirst($inv->last_name);
        }
        return null;
}

function investigator_detail($id,$field){
    $inv = App\User::find($id);
        if($inv){
                return $inv->$field;
        }
        return null;
}



function get_clinic_primary_contact($id){
        $clinic = App\Clinic::find($id);
        if($clinic){
                $user = App\User::where('clinic_id',$clinic->id)
                        ->where('is_primary_contact',1)
                        ->first();
                if($user){
                        return $user->first_name.' '.$user->last_name;
                }
        }
}