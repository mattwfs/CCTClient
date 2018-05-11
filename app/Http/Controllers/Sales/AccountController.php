<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Session;
use Mail;

class AccountController extends Controller
{
    
    public function register_page(){
        return view('sales.register');
    }

    
    
    public function register_user(Request $request){
        
        
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required',
                    'last_name'  => 'required',
                    'email'      => 'required|email|unique:users',
                    'password'   => 'required|min:6',
                    'confirm_password'   => 'required|same:password',
                ]);
                
                if($validator->fails()){
                       return redirect()->back()->withErrors($validator)->withInput();
                }
                
                if($request->has('username') && $request->username != ''){
                        $data['errors'][] = 'You dont seem to be human';
                        return redirect()->back()->withErrors($data)->withInput();
                }
                
                $user = new User;
                $user->first_name         = $request->first_name;
                $user->last_name          = $request->last_name;
                $user->email              = $request->email;
                $user->password           = bcrypt($request->password);
                $user->role_id            = $request->role_id;
                $user->user_type          = 'sales';
                $user->reset_key          = str_random(6);
                
                $user->save();
                
                
                $this->send_activation_email($user->id);
                
                \Session::flash('message','Account successfully created, please check your email for account activation');
                return redirect()->back();
        
        
    }
    
    
    
    
    
    private function send_activation_email($user_id)
        {
                $user = User::findOrFail($user_id);
                $logo = asset('assets/images/logo.png');
                Mail::send('emails.account_activation', ['user' => $user,'logo'=>$logo], function ($m) use ($user) {
                    $m->from('no-reply@cctclient.com', 'Conduct Clinical Trials');
                    $m->bcc("shilo@conductclinicaltrials.com","hello@cctclient.com");
                    $m->to($user->email, $user->first_name.' '.$user->last_name)->subject('Account Activation');
                });
                
        }
        
    /*
    public function activate_account($key)
        {
                $key_split = explode("-",$key);
                $error_data = [
                           'title' => 'Invalid activation key',
                           'message' => 'Looks like activation key is invalid or expired',
                        ];
                $success_data = [
                           'title' => 'Account Activated.',
                           'message' => 'Your account has been activated, you can now login to your account.',
                        ];
                $user = User::find($key_split[0]);
                if($user){
                        if($user->reset_key == $key_split[1]){
                                $user->reset_key = '';
                                $user->is_active =1 ;
                                $user->updated_at = $user->created_at ;
                                $user->save();
                                return view('errors.success',$success_data);
                        }
                        else{
                                return view('errors.invalid_key',$error_data);
                        }
                }
                else{
                        return view('errors.invalid_key',$error_data);
                }
        }*/
}
