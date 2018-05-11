<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Auth;
use Image;
use Mail;
use Hash;
use App\User;
use App\Specialization;
use App\Referral;
use App\Trial;
use App\Clinic;
use App\Application;
use Session;


class AccountsController extends Controller
{
        
        public function dashboard() {

                $specialization_ids = [];
                $finances = [];

                $user = User::find(auth()->user()->id);
                $specializations = $user->specializations;
                

                    foreach($specializations as $specialization){
                        array_push($specialization_ids,$specialization->id);
                    }

                    $final_trials=array();

                    $trials = \DB::table('trials')
                                    ->whereNull("deleted_at")
                                    ->where('status','!=',0)
                                    ->orderBy('id','DESC')->get();

                    foreach($trials as $trial){

                        $trial_specializations = explode(",",$trial->specialization_id);
                        foreach($trial_specializations as $trial_specialization){
                            foreach($specialization_ids as $id){
                                if($trial_specialization == $id){
                                    $final_trials[]=$trial;
                                }
                            }
                        }

                    }

                    foreach($user->finances as $finance){
                        if(!array_key_exists($finance->trial->id,$finances)){
                            $finances[$finance->trial->id] = $finance->earnings_amount;
                        } else {
                            $finances[$finance->trial->id] += $finance->earnings_amount;
                        }
                    }

                $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
                $data['finances'] = $finances;
                $data['trials'] = $final_trials;
                $data['specializations']= Specialization::all();
                return view('users.dashboard',$data);
        }

    public function opentrials() {

        $specialization_ids = [];
        $user = User::find(auth()->user()->id);
        $specializations = $user->specializations;


        foreach($specializations as $specialization){
            array_push($specialization_ids,$specialization->id);
        }

        $final_trials=array();

        $trials = Trial::whereNull("deleted_at")->where('status','!=',0)
            ->orderBy('id','DESC')->get();

        foreach($trials as $trial){
            $trial_specializations = explode(",",$trial->specialization_id);
            foreach($trial_specializations as $trial_specialization){
                foreach($specialization_ids as $id){
                    if($trial_specialization == $id){
                        if(is_null($trial->expires_on)){
                            $final_trials[]=$trial;
                        } else {
                            if($trial->expires_on >= time() || ($trial->expires_on <= time() && $trial->no_waitlist==0)){
                                $final_trials[]=$trial;
                            }
                        }
                    }
                }
            }
        }

        $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
        $data['trials'] = $final_trials;
        $data["specialization"] =0;
        return view('users.opentrials',$data);
    }

    public function closedtrials() {

        $specialization_ids = [];
        $user = User::find(auth()->user()->id);
        $specializations = $user->specializations;


        foreach($specializations as $specialization){
            array_push($specialization_ids,$specialization->id);
        }

        $final_trials=array();

        $trials = Trial::whereNull("deleted_at")->where('status','!=',0)
            ->orderBy('id','DESC')->get();

        foreach($trials as $trial){
            $trial_specializations = explode(",",$trial->specialization_id);
            foreach($trial_specializations as $trial_specialization){
                foreach($specialization_ids as $id){
                    if($trial_specialization == $id && $trial->expires_on >= time() ){
                        if(!is_null($trial->expires_on)){
                            if($trial->expires_on >= time() && $trial->no_waitlist==1){
                                $final_trials[]=$trial;
                            }
                        }
                    }
                }
            }
        }

        $data['applications'] = Application::where("user_id","=",$user->id)->where("status","=","selected")->get();
        $data['trials'] = $final_trials;
        $data["specialization"] =0;
        return view('users.closedtrials',$data);
    }
        
        
        //normal login
        public function user_login(Request $request) {

                $validator = Validator::make($request->all(), [
                    'user_email' => 'email|required',
                    'user_password' => 'required|min:2',
                ]);
                
                if($validator->fails()){
                        return redirect()->back()->withErrors($validator);
                }
                if($request->username != ''){
                       $data['errors'][] = 'Something is not right, we cannot let you in.';
                        return redirect()->back()->withErrors($data)->withInput();
                }
                $login_details = [
                        'email'         => $request->user_email,
                        'password'      => $request->user_password
                        //'role_id'       => get_role_id('user')
                ];


                if(Auth::attempt($login_details)){
                        if(auth()->user()->is_active == 0){
                            Auth::logout();
                            $data['errors'][] = 'You must activate your account and update your profile. The activation link has been sent to your email. If you haven\'t received it, please notify us at portal@cctclient.com.';
                            return redirect()->back()->withErrors($data);
                        } else {
                            if(auth()->user()->is_approved == 0 && auth()->user()->is_complete == 1 ){
                                Auth::logout();
                                $data['errors'][] = 'Your profile has been submitted for review. You will receive a notification once your account is active.';
                                return redirect()->back()->withErrors($data);
                            } else {
                                if(auth()->user()->role_id == get_role_id('sales_rep')){
                                    return redirect(url('rep'));
                                } else if(auth()->user()->role_id == get_role_id('sales_manager')){
                                        return redirect(url('sales_manager'));
                                }
                                elseif(auth()->user()->role_id == get_role_id('user') || auth()->user()->role_id == get_role_id('point_of_contact') || auth()->user()->role_id == get_role_id('study_coordinator'))
                                {
                                        return redirect(url('user'));
                                }
                                else
                                {
                                        Auth::logout();
                                        $data['errors'][] = 'Invalid email or password';
                                        return redirect()->back()->withErrors($data);
                                }

                            }
                        }
                }
                else
                {
                        $data['errors'][] = ' Invalid email or password';
                        return redirect()->back()->withErrors($data);
                }
                
        }
    
        
        
        
        
        // ajax login
        public function login(Request $request)
        {
                
                
                $validator = Validator::make($request->all(), [
                    'user_email' => 'email|required',
                    'user_password' => 'required|min:2',
                ]);
                
                if($validator->fails()){
                        $response['response_type'] = 'error';
                        $response['message'] = $validator->errors();
                        echo json_encode(array_filter($response));
                }
                $login_details = [
                        'email'         => $request->user_email,
                        'password'      => $request->user_password,
                        'is_active'     => 1,
                        'deleted_at'    => null,
                        ];

                if(Auth::attempt($login_details)){
                        //return redirect('/');
                                $response['response_type'] = 'success';
                                $response['message'] = 'Login successfull';
                                $response['redirect'] = url('user');
                                echo json_encode(array_filter($response));
                        }
                else{
                        echo json_encode([
                                'response_type' => 'error',
                                'message' => ['login_failed' => 'Invalid Email or password !']
                        ]);
                }
                
                
                
                
        }
        
        
        
        
        public function admin_login(Request $request)
        {
                $data['issues']  = [];
                $messages =[
                        'email.email' => 'Thats not a valid email.',
                        'email.required' => 'Hey, we need your email address.',
                        'password.required' => 'Password is required',
                ];
               $validator = Validator::make($request->all(), [
                    'email' => 'email|required',
                    'password' => 'required',
                ],$messages);
                
                if($validator->fails()){
                        return redirect()->back()->withErrors($validator)->withInput();
                }
                
                $expected_sum = $request->val1+$request->val2;
                if($expected_sum != $request->sum){
                        $data['errors'][] = 'Sum of two numbers is not correct';
                        return redirect()->back()->withErrors($data)->withInput();
                }
                if($request->username != ''){
                       $data['errors'][] = 'You dont seem to be human';
                        return redirect()->back()->withErrors($data)->withInput();
                }
                
                
                
                
                $login_details = [
                        'email' => $request->email,
                        'password' => $request->password,
                        'is_active' => 2,
                        'role_id' => get_role_id('admin'),
                ];
                if(Auth::attempt($login_details)){
                        return redirect('admin');
                }
        }
        
        
        
        
        public function register_page() {
                return view('accounts.register');
        }
        
        
        public function register_user(Request $request) {
                $validator = Validator::make($request->all(), [
                    'clinic_name' => 'required',
                    'clinic_phone' => 'required',
                    'clinic_address' => 'required',
                    'clinic_city' => 'required',
                    'clinic_state' => 'required',
                    'clinic_postcode' => 'required',
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
                
                $clinic = new Clinic;
                $clinic->name    = $request->clinic_name;
                $clinic->email   = $request->clinic_email;
                $clinic->phone   = $request->clinic_phone;
                $clinic->address = $request->clinic_address;
                $clinic->state = $request->clinic_state;
                $clinic->city = $request->clinic_city;
                $clinic->postcode = $request->clinic_postcode;
                $clinic->primary_location = 1;
                $clinic->save();
                
                $user = new User;
                $user->first_name         = $request->first_name;
                $user->last_name          = $request->last_name;
                $user->email              = $request->email;
                $user->password           = bcrypt($request->password);
                $user->role_id            = get_role_id('user');
                $user->clinic_id          = $clinic->id;
                $user->is_primary_contact = 1;
                $user->user_type          = 'clinic';
                $user->reset_key          = str_random(6);
                
                if(was_email_referred($request->email)):
                        $user->referred_by = was_email_referred($request->email);
                endif;
                
                $user->save();
                
                
                $this->send_activation_email($user->id);
                
                \Session::flash('message','Account successfully created, please check your email for account activation');
                return redirect()->back();
        }
        
        
        
        
        
        function complete_profile(Request $request)
        {
                $validator = Validator::make($request->all(), [
                    'first_name'        => 'required',
                    'last_name'         => 'required',
                    'street_address'    => 'required',
                    'city'              => 'required',
                    'postcode'          => 'required',
                    'state'             => 'required',
                    'phone'             => 'required|numeric',
                    'practise_name'     => 'required'
                ]);
                
                if($validator->fails()){
                        return redirect()->back()->withErrors($validator);
                }
                
                $user_id = auth()->user()->id;
                $user = User::find($user_id);
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->street_address = $request->street_address;
                $user->city = $request->city;
                $user->postcode = $request->postcode;
                $user->state = $request->state;
                $user->phone = $request->phone;
                $user->practise_name = $request->practise_name;
                $user->is_complete = 1;
                $user->save();
                if(session()->has('referral_register')){
                      $ref = Referral::where("email",session()->get('referral_register'))->first();
                        if($ref){
                          $trial_id = $ref->trial_id;
                        return redirect('user/trial/'.$trial_id);
                        }
                        
                }
                \Session::flash('message','Account successfully completed. Please allow 24-48 hours for our admins to review your information for approval.');
                Auth::logout();
                return redirect('login');
        }
        
        
        function update_profile(Request $request)
        {
                $validator = Validator::make($request->all(), [
                    'first_name'        => 'required',
                    'last_name'         => 'required',
                    'email'             => 'required|email',
                    'street_address'    => 'required',
                    'city'              => 'required',
                    'postcode'          => 'required',
                    'state'             => 'required',
                    'phone'             => 'required|numeric',
                    'practise_name'     => 'required',
                    'time_zone'         => 'required',
                ]);
                
                if($validator->fails()){
                        return redirect()->back()->withErrors($validator);
                }
                
                $user_id = auth()->user()->id;
                $user = User::find($user_id);
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->street_address = $request->street_address;
                $user->city = $request->city;
                $user->postcode = $request->postcode;
                $user->state = $request->state;
                $user->phone = $request->phone;
                $user->practise_name = $request->practise_name;
                $user->time_zone = $request->time_zone;
                $user->expiry_date = $request->expiry_date;
                $user->npi = $request->npi;
                $user->license_number = $request->license_number;
                $user->save();
                $user->specializations()->sync($request->specializations);
                \Session::flash('message','Profile Updated !');
                return redirect()->back();
        }
        
        
        
        
        public function edit_profile()
        {
                $data['states'] = get_states();
                $data['specializations'] = Specialization::all();
                return view('users.edit-profile',$data);
        }
        
        public function login_page()
        {
                return view('accounts.login');
        }
        
        public function admin_login_page()
        {
                return view('accounts.admin-login');
        }
        
        
        
        
        public function forgot_password() {
                return view('accounts.forgot-password');
        }
        
        
        
        public function send_password_link(Request $request) {
                $validator = Validator::make($request->all(),[
                        'email' => 'email|exists:users'
                ]);
                
                if($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                }
                
                $user = User::where("email",$request->email)
                                ->where("is_active",1)
                                ->first();

                if($user) {
                    
                        $str = str_random(6);
                        $key = $str.'_-_'.$user->id;
                        $user->reset_key = $str;
                        $user->save();
                        $link = url('reset-password/'.$key);
                        $message = 'Someone requested a password reset link for your account. Please click on the link below to create a new password for your account.<br/><br/>';
                        $message .= '<a href="'.$link.'">Reset your password</a>';
                        
                        send_notification($user->id,$message);
                        
                        \Session::flash("message",'Password reset link successfully sent to your email.');
                        
                        return redirect()->back();
                        
                }
                else {
                        dd('Looks like your account is not active and you can not reset your password');
                }
        }
        
        
        
        function password_reset_page($key) {
                
                $arr = explode("_-_",$key);
                $reset_key = $arr[0];
                $user_id = $arr[1];
                
                
                $user = User::where("id",$user_id)
                                ->where("reset_key",$reset_key)
                                ->first();
                
                $data['user_id'] = $user_id;
                $data['reset_key'] = $reset_key;
                if($user){
                      return view('accounts.reset-password',$data);  
                }
        }
        
        
        
        
        
        
        function password_reset(Request $request) {
                $messages = [
                        'update.required' => 'Invalid request',
                        'update.numeric' => 'Invalid request',
                        'key.required' => 'Invalid request',
                ];
                $validator = Validator::make($request->all(),[
                        'update' => 'required|numeric',
                        'key' => 'required',
                        'password' => 'required|min:6',
                        'confirm_password' => 'required|same:password',
                ]);
                
                if($validator->fails($validator)){
                        return redirect()->back()->withErrors($validator);
                }
                
                $user = User::find($request->update);
                if(! $user){
                        $data['errors'][] = 'Something looks fishy, password not changed';
                    return redirect()->back()->withErrors($data); 
                }
                if($user){
                        
                        if($user->reset_key != $request->key){
                                $data['errors'][] = 'Looks like password reset key expired.';
                                return redirect()->back()->withErrors($data);      
                        }
                        
                        $user->password = \Hash::make($request->password);
                        $user->reset_key = '';
                        $user->save();
                        
                        \Session::flash('message','Password updated successfully, please login.');
                        return redirect(url('login'));
                        
                }
        }
        
        
        
        
        
        public function logout()
        {
                Auth::logout();
                return redirect('/');
        }
        
        public function activate_account($key)
        {
                $key_split = explode("-",$key);
                $error_data = [
                           'title' => 'Invalid activation key',
                           'message' => 'Looks like activation key is invalid or expired',
                        ];
                $success_data = [
                           'title' => 'Congratulations',
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
        }
        
        
        public function upload_profile_photo(Request $request) {
                
        if($request->hasFile('profile_pic')):
                    $upload_path=base_path('uploads/');
                    $user= User::find(auth()->user()->id);         
        
                    $filename=$user->id.'-'.time();
                
                    $normal_image = $filename.'.jpg';
                    $small_image = 'small-'.$filename.'.jpg';
                
					$temp=$request->file('profile_pic')->getPathName();
        
					//$img =Image::make($temp)->resize(300, 300);
					$img =Image::make($temp);
                    $img->fit(300, 300, function ($constraint) {
                                $constraint->upsize();
                    });
                    $img->save(base_path('uploads/').$normal_image, 100);
                
                
                    $img2 =Image::make($temp);
                    $img2->fit(80, 80, function ($constraint) {
                                $constraint->upsize();
                    });
					$img2->save(base_path('uploads/').$small_image, 70);
                    
                    //$user= User::find(auth()->user()->id);
                    $user->photo=$normal_image;
                    $user->save();
                        return redirect('user');
                else:
                
                        echo 'file not selected';
                
                endif;
                       
                    //return redirect('user');
     
        }
        
        
        private function send_activation_email($user_id)
        {
                $user = User::findOrFail($user_id);
                $logo = asset('assets/images/logo.png');
                Mail::send('emails.account_activation', ['user' => $user,'logo'=>$logo], function ($m) use ($user) {
                    $m->from('no-reply@cctclient.com', 'Conduct Clinical Trials');
                    $m->to($user->email, $user->first_name.' '.$user->last_name)->subject('Account Activation');
                    $m->bcc(["shilo@conductclinicaltrials.com","hello@cctclient.com"]);
                });
                
        }
        
        public function change_password_page() {
                
                return view('accounts.change-password');
        }

        public function training() {

            return view('users.training');
        }


        public function change_password(Request $request) {
                
                $validator = Validator::make($request->all(),[
                        
                        'current_password' => 'required',
                        'password' => 'required|min:6',
                        'confirm_password' => 'required|same:password',
                ]);
                
                if($validator->fails()){
                        return redirect()->back()->withErrors($validator);
                }
                
                $user = User::find(auth()->user()->id);
                /*if($user->password != Hash::make($request->current_password)){
                        $data['errors'][] = 'Current password is not correct';
                        return redirect()->back()->withErrors($data);
                }*/
                
                if(! Hash::check($request->current_password,$user->password)){
                        $data['errors'][] = 'Current password is not correct';
                        return redirect()->back()->withErrors($data);
                }
                
                $user->password = bcrypt($request->password);
                $user->save();
                
                \Session::flash("message","Password successfully changed!");
                Auth::logout();
                return redirect(url('login'));
                
        }

    function create_additional_user(Request $request){
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_type' => 'required',
            'email' => 'required|email|unique:users',
        ];


        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->is_active = 1;
        $user->is_approved = 1;
        $user->is_complete = 1;
        $user->user_type = $request->user_type;
        $user->role_id = get_role_id("user");
        $user->clinic_id = $request->clinic_id;
            $user->npi = $request->npi;
            $user->expiry_date = $request->expiry_date;
            $user->license_number = $request->medical_license;
        $user->time_zone = $request->time_zone;
        $user->is_partner = 0;

        $plain_password = str_random(6);
        $user->password = \Hash::make($plain_password);

        $user->save();

        if($user->role_id == get_role_id('study_coordinator') || $user->role_id == get_role_id('user') ){
            $message = 'Your account was created<br/><hr/>';
            $message .= '<strong>Login details:</strong><br/><br/>';
            $message .= 'Email:<br/>'.$user->email.'<br/><br/>';
            $message .= 'Password:<br/>'.$plain_password.'<br/><br/>';
            $message .= 'Please change this password, once you are logged in.';
            send_notification($user->id,$message);
        }

        if($user->role_id == get_role_id('user') ) {
            $user->specializations()->sync($request->specializations);
        }


        $response['response_type'] = 'success';
        $response['message'] = 'Account successfully created, please check your email for account activation';
        echo json_encode(array_filter($response));
    }
        
}