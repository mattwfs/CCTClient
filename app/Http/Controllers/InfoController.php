<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InfoController extends Controller
{
    public function unauthorized()
    {
        return view('errors.unauthorized');
    }

    public function privacy()
    {
        return view('privacy');
    }
    
    
    function callback_request(Request $request) {
        $user_id = auth()->user()->id;
        call_me_back($user_id);
        return 'success';
        exit();
    }
}
