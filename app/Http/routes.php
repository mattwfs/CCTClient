<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () { return view('welcome'); });
Route::get('/info',function (){ return view('info'); });
Route::get('/not-authorized/','InfoController@unauthorized');
Route::get('privacy','InfoController@privacy');

require app_path('Http/Routes/guests.php');
require app_path('Http/Routes/auth.php');
require app_path('Http/Routes/users.php');
require app_path('Http/Routes/admin.php');
require app_path('Http/Routes/sales-rep.php');
require app_path('Http/Routes/sales-manager.php');