<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController as Controller;
use App\User;
use App\Specialization;
use App\Application;
use App\Trial;
use App\Finance;
use App\Agreement;
use App\Clinic;
use Validator;
use Hash;

class UsersController extends Controller
{
    //list of users
    public function list_all() {
        $data['clinics'] = Clinic::where("deleted_at",null)->where("primary_location","=","1")->orderBy("id","DESC")->get();
        $data['specializations'] = Specialization::all();
        $data['states'] = get_states();
        return view('admin.clinics',$data);
    }
    
    
    public function list_sales_rep(){
        $data['users'] = User::where('role_id',get_role_id('sales_rep'))->whereNull("deleted_at")->get();
        $data['users_managers'] = User::where('role_id',get_role_id('sales_manager'))->whereNull("deleted_at")->get();
        return view('admin.sales_reps',$data);
    }

    public function sales_manager($id){
        $data["sales_manager"] = User::find($id);
        $data['users'] = User::where('role_id',get_role_id('sales_rep'))->where('sales_manager_id',$id)->get();
        $data['sales_reps'] = User::where('role_id',get_role_id('sales_rep'))->whereNull('sales_manager_id')->get();
        return view('admin.sales_manager',$data);
    }

    public function list_clinic($id){
        $data["all_clinics"] = Clinic::whereNull("deleted_at")->orderBy("name","asc")->get();
        $data['clinics'] = Clinic::where('sales_rep',$id)->get();
        $data['sales_rep'] = User::find($id);
        return view('admin.clinics-sales-rep',$data);

    }
    
    public function clinic_users($id){
        $clinic = Clinic::find($id);
        $data["clinic_id"] = $id;
        $data['users'] = User::where('clinic_id',$id)->whereNull("deleted_at")->get();
        $data["sales_rep"] = User::find($clinic->sales_rep);
        $data['specializations'] = Specialization::all();
        $data['states'] = get_states();
        return view('admin.users',$data);
    }

    public function manager_users($id){
        $user = User::find($id);
        $data["manager"] = $user;
        $data['sales_reps'] = User::where('clinic_id',$id)->whereNull("deleted_at")->get();
        $data['specializations'] = Specialization::all();
        $data['states'] = get_states();
        return view('admin.manager-users',$data);
    }


    public function all_users(){
        $data['users'] = User::where("role_id",get_role_id("user"))->whereNull("deleted_at")->get();
        return view('admin.all-users',$data);
    }

    // add user
    public function create(Request $request) {
      
        
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
        if($request->has('is_partner')):
            $user->is_partner = $request->is_partner;
        else:
            $user->is_partner = 0;
        endif;
        
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

    public function associate_sales_rep(Request $request){

        $user = User::find($request->sales_rep_id);;
        if($user){
            $user->sales_manager_id = $request->sales_manager_id;
            $user->save();

            $response['response_type'] = 'success';
            $response['message'] = 'Sales Rep successfully added.';
            echo json_encode(array_filter($response));
        } else {
            $response['response_type'] = 'error';
            $response['message'] = 'Something went wrong.';
            echo json_encode(array_filter($response));
        }

    }


    public function associate_clinic(Request $request){

        $clinic = Clinic::find($request->clinic_id);;
        if($clinic){
            $clinic->sales_rep = $request->sales_rep_id;
            $clinic->save();

            $response['response_type'] = 'success';
            $response['message'] = 'Clinic successfully added.';
            echo json_encode(array_filter($response));
        } else {
            $response['response_type'] = 'error';
            $response['message'] = 'Something went wrong.';
            echo json_encode(array_filter($response));
        }

    }

    // edit user
    public function edit($id) {
        $data["clinics"] = Clinic::whereNull("deleted_at")->orderBy("name","asc")->get();
        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['states'] = get_states();
            $data['specializations'] = Specialization::all();
            return view('admin.user-edit',$data);
        }else{
            echo 'user not found';
        }
        
    }

    public function sales_edit($id) {

        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['states'] = get_states();
            $data['specializations'] = Specialization::all();
            return view('admin.sales-edit',$data);
        }else{
            echo 'user not found';
        }

    }

    //update user
    public function update(Request $request) {
       
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ];
        
        $validator = Validator::make($request->all(),$rules);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        
        $user = User::find($request->id);
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->is_active = $request->is_active;
        $user->license_number = $request->license_number;
        $user->expiry_date = $request->expiry_date;
        $user->time_zone = $request->time_zone;
        $user->source = $request->source;
        $user->clinic_id = $request->clinic_id;
        $user->location_id = $request->location_id;
        //if($user->is_approved==0)

        $user->is_approved = $request->is_approved;



        if($request->role_id ==get_role_id('admin')) {
            $user->is_active = 2;
        }
        $user->is_partner = $request->is_partner;
        
        if($request->has('npi')):
            $user->npi = $request->npi;
        endif;

        
        if($request->has("new_password")){
            
            $plain_password = str_random(6);
            $user->password = \Hash::make($plain_password);
            
        }
        
        $user->save();
        if($request->specializations){
            $user->specializations()->sync($request->specializations);
        }
        if($request->has("new_password")){
            
            $message = 'Your account login detail was automatically updated by system<br/><br/>';  
            $message .= '<strong>Here are new login details :</strong><br/><br/>';  
            $message .= 'Email: '.$user->email.'<br/>';  
            $message .= 'Password: '.$plain_password.'<br/>';  
            $message .= 'Please change this password, once you are logged in.';  
            send_notification($user->id,$message);
            
        }
        
        $message = 'Your account was updated by admin'; 
        //send_notification($user->id,$message);
        
        \Session::flash('message','Update successful!');
        return redirect()->back();
        
    }
    
    
    
    function profile($id) {
        $data['trials'] = Trial::where("deleted_at",null)->orderBy("id","DESC")->get();
        $data['user'] = User::find($id);
        $data['specializations'] = $data['user']->specializations;
        $data['applications'] = $data['user']->applications;
        $data['referrals'] = $data['user']->referrals;
        $data['finances'] = $data['user']->finances;

        return view('admin.user-profile',$data);
    }
    
    function add_finance(Request $request) {
        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'earning_amount' => 'required',
            'user_id' => 'numeric|required',
            'trial_id' => 'numeric'
        ]);
        
        if($validator->fails()) {
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            exit();
        }
        
        $finance = new Finance;
        $finance->user_id = $request->user_id;
        $finance->title = $request->title;
        $finance->payment_date = strtotime($request->date);
        $finance->earnings_for = $request->earning_for;
        $finance->earnings_amount = $request->earning_amount;
        $finance->trial_id = $request->trial_id;
        $finance->save();
        $response['response_type'] = 'success';
        $response['message'] = 'Financial Data Added!';
        echo json_encode(array_filter($response));
    }

    function delete(Request $request) {
        $user = User::find($request->delete_id);
        if($user){
            $admin = User::find(auth()->user()->id);
            $password = $request->admin_password;
            
            if(! Hash::check($request->admin_password,$admin->password)){
                echo '<p class="text-danger">Password is not correct</p>';
                die();
            }
            
        $user->deleted_at = time();
        $user->is_active = 0;
        $user->role_id = 0;
        $user->user_type = null;
        $user->is_complete = 0;
        $user->email = "";
        $user->save();
            echo 'success';
            die();
            
            
        }
    }
    
    
    
    function user_agreement_page($id){
        $data['agreement'] = '';
        $data['user'] = User::find($id);
        $agreement = Agreement::where('user_id',$id)->first();
        if($agreement){
           $data['agreement']=$agreement->content;
        }
        return view('admin.agreement',$data);
    }


    function update_receive_financials(Request $request){
        $user = User::find($request->id);
        $user->receive_financials = $request->receive_financials=="true"?1:0;
        $user->save();
        $response['response_type'] = 'success';
        $response['message'] = 'User Updated';
        echo json_encode(array_filter($response));
    }

    function update_receive_emails(Request $request){
        $user = User::find($request->id);
        $user->receive_emails = $request->receive_emails=="true"?1:0;
        $user->save();
        $response['response_type'] = 'success';
        $response['message'] = 'User Updated';
        echo json_encode(array_filter($response));
    }
    
    function user_agreement_post(Request $request){
        
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'content' => 'required'
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        
        $agreement = Agreement::where('user_id',$request->user_id)->first();
        if(! $agreement){
            $agreement = new Agreement;
            $agreement->user_id = $request->user_id;
        }
        $agreement->content = $request->content;
        $agreement->save();
        \Session::flash('message','Agreement updated');
        return redirect()->back();
        
    }
    
    
}
