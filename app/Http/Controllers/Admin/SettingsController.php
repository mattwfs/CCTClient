<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Settings;
use Session;

class SettingsController extends Controller
{
    function index() {
        $data['agreement'] = Settings::find(1);
        return view('admin.settings',$data);
   }
}
