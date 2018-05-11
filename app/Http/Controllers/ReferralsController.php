<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Trial;
use App\Referral;
use App\Application;
use App\Clinic;
use Validator;
use Auth;

class ReferralsController extends Controller
{
    function referrals() {
        $user_id = auth()->user()->id;
        $data['referrals'] = Referral::where("user_id",$user_id)
                                        ->orderBy("id","DESC")
                                        ->paginate(10);
        $data['referrals']->setPath(url('user/referrals'));
        
        return view('users.referrals',$data);
    }
    
    function create_referral(Request $request) {
        if(! can_referr($request->trial_id)){
            dd('You can not refer this trial');
        }
        $messages = [
           'trial_id.required'          => 'Seems like you did something wrong',
            'email.required'            => 'You must provide friend&apos;s email',
            'email.email'               => 'Looks like email you provided is not valid',
            'email.unique'    => 'This email is already in our referrals list',
            'name.required'             => 'You must provide friend&apos;s name'
        ];
        $validator = Validator::make($request->all(),[
            'email'     => 'required|email|unique:referrals|unique:users',
            'name'      => 'required',
            'trial_id'  => 'required'
        ],$messages);

        if($validator->fails()) {
                $response['response_type'] = 'error';
                $response['message'] = $validator->errors();
                echo json_encode(array_filter($response));
                die();
        }

        $referral = new Referral;
        $referral->user_id =  auth()->user()->id;
        $referral->trial_id = $request->trial_id;
        $referral->email = $request->email;
        $referral->name = $request->name;
        $referral->referral_key = encrypt($request->email);
        $referral->save();
        /*
        Email code goes here
        */
        send_referral_email($referral->id);
        $response['response_type'] = 'success';
        $response['message'] = 'Referral successfully sent. Thank you for your referral.';
        echo json_encode(array_filter($response));
     }

    function create_internal_referral(Request $request) {

        $messages = [
            'email.required'            => 'You must provide friend&apos;s email',
            'email.email'               => 'Looks like email you provided is not valid',
            'email.unique'    => 'This email is already in our referrals list',
            'name.required'             => 'You must provide friend&apos;s name'
        ];
        $validator = Validator::make($request->all(),[
            'email'     => 'required|email|unique:referrals|unique:users',
            'name'      => 'required',
        ],$messages);

        if($validator->fails()) {
            $response['response_type'] = 'error';
            $response['message'] = $validator->errors();
            echo json_encode(array_filter($response));
            die();
        }

        $referral = new Referral;
        $referral->user_id =  auth()->user()->id;
        $referral->email = $request->email;
        $referral->name = $request->name;
        $referral->referral_key = encrypt($request->email);
        $referral->save();
        /*
        Email code goes here
        */
        send_generic_referral_email($referral->id);

        \Session::flash('message','Referral successfully sent. Thank you for your referral.');

        return redirect()->back();
    }

    function accept_referral($key) {
        $referral = Referral::where("email",decrypt($key))->first();
        //dd($referral);
        if(! $referral) {
            die('Invalid referral token');
        }

        if($referral->referral_key != $key) {
            die('Invalid referral token');
        }

        if($referral->email == decrypt($key) && $referral->referral_key == $key) {
            session()->put("referral_register",$referral->email);
            $data['referral'] = $referral;
            return view('referral-registration',$data);
        }

    }

    function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'clinic_name' => 'required',
            'clinic_phone' => 'required',
            'clinic_address' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'referral_id' => 'required',
        ]);


        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $referral = Referral::find($request->referral_id);

        $clinic = new Clinic;
        $clinic->name = $request->clinic_name;
        $clinic->email = $request->clinic_email;
        $clinic->phone = $request->clinic_phone;
        $clinic->address = $request->clinic_address;
        $clinic->sales_rep = $referral->user_id;
        $clinic->save();

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $referral->email;
        $user->password = bcrypt($request->password);
        $user->role_id = get_role_id('user');
        $user->reset_key = str_random(6);
        $user->is_active = 1;
        $user->clinic_id = $clinic->id;
        $user->is_primary_contact = 1;
        $user->user_type = 'clinic';
        $user->referred_by = $referral->user_id;
        $user->save();

        $referral->status = 'account_created';
        $referral->referral_key = '';
        $referral->save();

        $message = 'We just wanted to let you know that <strong>'.ucwords($referral->name).'<strong> has just registered to our system with your referral link.';
        send_notification($referral->user_id,$message);

        if(session()->has('referral_register')){

                $login_details = [
                        'email'         => $user->email,
                        'password'      => $request->password,
                        'is_active'     => 1,
                        'role_id'       => get_role_id('user')
                        ];

                if(Auth::attempt($login_details)){
                                $response['response_type'] = 'success';
                                $response['message'] = 'Login successfull';
                                $response['redirect'] = url('user');
                                return redirect(url('user'));
                    }


        }else{
            $message = 'Your account at www.cctclient.com is ready to use, please login and apply for study you have been referred to.';
            send_notification($user->id,$message);
        }
    }


    function referral_application($id) {

        $ref = Referral::find($id);
        if(! $ref){
            return redirect(url('not-authorized'));
        }

        if($ref->user_id != auth()->user()->id){
            return redirect(url('not-authorized'));
        }

        $user = User::where("email",$ref->email)->first();
        if(! $user){
            return redirect(url('not-authorized'));
        }

        $data['applications'] = Application::where("user_id",$user->id)
                                ->orderBy('id','DESC')
                                ->paginate(10);
        $data['applications']->setPath(url('user/referral/application/'.$id.'/'));
        return view('users.referral-application',$data);
    }
    
}
