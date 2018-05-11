<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController as Controller;
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
        $data['referrals'] = Referral::orderBy("id","DESC")
                                        ->paginate(10);
        $data['referrals']->setPath(url('admin/referrals'));
        
        return view('admin.referrals',$data);
    }

    public function edit($id) {

        $data['referral'] = Referral::find($id);

        return view('admin.referrals-edit',$data);

    }

    function update(Request $request)
    {

        $referral = Referral::find($request->id);
        $referral->notes = $request->referral_comment;
        $referral->status = $request->referral_status;


        $referral->save();
        \Session::flash('message','Referral Updated !');
        return redirect()->back();
    }


}
