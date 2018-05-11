<?php
function is_applied($trial_id) {
        
        $application = App\Application::where("user_id",auth()->user()->id)
                                        ->where("trial_id",$trial_id)
                                        ->first();
        if($application){
                return true;
        }
        return false;
    
}

function is_partner($user_id)
{
        $user = App\User::find($user_id);
        if($user->is_partner){
                return true;
        }
        return false;
}


function was_email_referred($email) {
        
        $ref = App\Referral::where("email",$email)->first();
        
        if($ref){
                return $ref->user_id;
        }
        
        return false;
}

//M.f09)U,}yea
//cctclien_cct
function is_first_referral_application($user_id) {
        $user = App\User::find($user_id);
        
        if($user){
             $ref = App\Referral::where("email",$user->email)
                                ->where("status","!=",'applied')
                                ->first();
                if(! $ref){
                     return false;   
                }
        }else{
                return false;
        }
        return true;
}





function is_referral($user_id) {
        
        $user = App\User::find($user_id);
        if(! $user){
                return false;
        }
        
    $ref = App\Referral::where("email",$user->email)->first();
        if(! $ref){
                return false;
        }
        return $ref->user_id;
}




function is_referred($user_email,$trial_id){
        $ref = App\Referral::where("email",$user_email)
                                ->where("trial_id",$trial_id)
                                ->first();
        if($ref){
                return true;
        }else{
                return false;
        }
                        
}



function is_user($key,$user_id)
{
        $user = App\User::find($user_id);
        $role_id = $user->role_id;
        $role = App\Role::find($role_id);
        
        if($role->key == $key){
                return true;
        }
        
        return false;
}



function is_profile_complete($user_id = '')
{
        if($user_id==''){
                $user_id = auth()->user()->id;
        }
       $user = App\User::find($user_id);
        if(! $user->is_complete){
                return false;
        }
        return true;
}



function is_trial_expired($trial_id) {
        $trial = App\Trial::find($trial_id);
        if($trial->expires_on){
            if($trial->expires_on < time()) {
                    return true;
            }    
        }
        return false;
}

function is_referral_registration(){
      if(session()->has('referral_register')){
              return true;
      }else{
              return false;
      }  
}