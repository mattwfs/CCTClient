<?php

namespace App\Http\Controllers\SalesManager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Clinic;
use App\Specialization;
use Validator;
use Session;
class UsersController extends Controller
{



        public function index($id){
                $data['user'] = User::find($id);
                if($data['user']){
                        $clinic = Clinic::find($data['user']->clinic_id);
                        if($clinic && $clinic->sales_rep==auth()->user()->id){
                                $data['specializations'] = $data['user']->specializations;
                                $data['applications'] = $data['user']->applications;
                                return view('sales.user',$data);
                        }
                }
        }

        public function add(){
                $data['states'] = get_states();

                $data['users'] = User::where('role_id',get_role_id('user'))->get();

                $data['specializations'] = Specialization::all();
                return view('sales.add_clinic',$data);
        }

        public function associate_clinic(Request $request){

            $user = User::find($request->id);
            $clinic = $user->clinic;

            $clinic->sales_rep = auth()->user()->id;
            $clinic->save();

            Session::flash('message','Clinic Added');
            return redirect()->back();

        }


        public function create_old_MATTDELETE(Request $request) {
                $validator = Validator::make($request->all(), [
                    'clinic_name' => 'required',
                    'clinic_phone' => 'required',
                    'clinic_address' => 'required',
                    'first_name' => 'required',
                    'last_name'  => 'required',
                    'email'      => 'required|email|unique:users'
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
                $clinic->phone   = $request->clinic_phone;
                $clinic->address = $request->clinic_address;
                $clinic->sales_rep = auth()->user()->id;
                $clinic->save();

                $user = new User;
                $user->first_name         = $request->first_name;
                $user->last_name          = $request->last_name;
                $user->email              = $request->email;
                $user->role_id            = get_role_id('user');
                $user->clinic_id          = $clinic->id;
                $user->is_primary_contact = 1;
                $user->is_active           = 1;
                $user->user_type          = 'clinic';
                $plain_password           = str_random(6);
                $user->password           = \Hash::make($plain_password);
                $user->save();

                $message = 'A Clinic account for <strong>'.$user->clinic->name.'</strong> was created by <strong>'.auth()->user()->first_name.' '.auth()->user()->last_name.'</strong>, Please login and manage your clinic.<br/><hr/>';
                $message .= '<strong>Login details:</strong><br/><br/>';
                $message .= 'Email: '.$user->email.'<br/>';
                $message .= 'Password: '.$plain_password.'<br/>';
                $message .= 'Please change this password, once you are logged in.';
                send_notification($user->id,$message,1);

                Session::flash('message','Clinic Added');
                return redirect()->back();
        }

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
        $user->is_approved = 0;
        $user->is_complete = 1;
        $user->user_type = $request->user_type;
        $user->role_id = get_role_id("user");
        $user->clinic_id = $request->clinic_id;
        $user->source = "Sales";
            $user->npi = $request->npi;
            $user->expiry_date = $request->expiry_date;
            $user->license_number = $request->license_number;

        $user->time_zone = $request->time_zone;
        $plain_password = str_random(6);
        $user->password = \Hash::make($plain_password);

        $user->save();

        if($user->role_id == get_role_id('study_coordinator') || $user->role_id == get_role_id('user') ){
            $message = 'Your account was created<br/><hr/>';
            $message .= '<strong>Login details:</strong><br/><br/>';
            $message .= 'Email:<br/>'.$user->email.'<br/><br/>';
            $message .= 'Password:<br/>'.$plain_password.'<br/><br/>';
            $message .= 'Please change this password, once you are logged in.';
            send_notification($user->id,$message,1);
        }

        if($user->role_id == get_role_id('user') ) {
            $user->specializations()->sync($request->specializations);
        }



        $response['response_type'] = 'success';
        $response['message'] = 'Account successfully created, please check your email for account activation';
        echo json_encode(array_filter($response));
    }

    // edit user
    public function edit($id) {

        $user = User::find($id);
        if($user){
            $data['user'] = $user;
            $data['states'] = get_states();
            $data['specializations'] = Specialization::all();
            return view('sales.user-edit',$data);
        }else{
            echo 'user not found';
        }

    }

    public function clinic_edit($id)
    {
        $data["clinic"] = Clinic::find($id);
        $data['states'] = get_states();
        $data['specializations'] = Specialization::all();
        return view('sales.clinic-edit',$data);
    }





    //update user
    public function update(Request $request) {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'specializations' => 'required'
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

        if($user->is_approved==0)
            $user->is_approved = $request->is_approved;


        if($request->role_id ==get_role_id('admin')) {
            $user->is_active = 2;
        }
        $user->is_partner = $request->is_partner;

        $user->time_zone = $request->time_zone;
        $user->expiry_date = $request->expiry_date;
        $user->npi = $request->npi;
        $user->license_number = $request->license_number;




        if($request->has("new_password")){

            $plain_password = str_random(6);
            $user->password = \Hash::make($plain_password);

        }

        $user->save();

        $user->specializations()->sync($request->specializations);

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

        \Session::flash('message','Update successfull!');
        return redirect()->back();

    }
}
