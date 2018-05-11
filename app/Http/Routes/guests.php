<?php
Route::group([
    'middleware' => 'guest'
    ], function (){
    
        Route::get('login','AccountsController@login_page');
        Route::get('forgot-password',function(){return view('accounts.forgot-password');});
        Route::get('reset-password',function(){return view('accounts.reset-password');});
        //Route::post('user-login','AccountsController@login');
        Route::post('login','AccountsController@user_login');
        //Route::post('create-account','AccountsController@register');
        Route::get('register','AccountsController@register_page');
        Route::post('register','AccountsController@register_user');
    
        Route::get('sales-rep/register','Sales\AccountController@register_page');
        Route::post('sales-rep/register','Sales\AccountController@register_user');
    
        Route::get('backdoor','Admin\AccountsController@login');
        Route::post('backdoor','Admin\AccountsController@signin');
        
        Route::post('referral/register','ReferralsController@register');
        Route::get('activate-account/{key}','AccountsController@activate_account');
        Route::get('referral/{key}','ReferralsController@accept_referral');
        Route::get('forgot-password','AccountsController@forgot_password');
        Route::post('forgot-password','AccountsController@send_password_link');
    
        Route::get('reset-password/{key}','AccountsController@password_reset_page');
        Route::post('reset-password','AccountsController@password_reset');
    
    });
