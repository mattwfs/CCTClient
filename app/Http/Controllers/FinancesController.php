<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class FinancesController extends Controller
{
    function index() {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if($user && $user->is_partner):
            $data['finances'] = $user->finances;
            return view('users.finances.finances-list',$data);
        else:
            return redirect(url('not-authorized'));
        endif;
    }
}
