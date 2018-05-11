<?php
// users routes
Route::group([
    'prefix' => 'user',
    'middleware' => 'role:user'],
    function () {
        //complete_profile
    
        /*complete profile middleware*/
        Route::get('investigators','InvestigatorsController@index');  
        Route::post('investigator/update','InvestigatorsController@update');
        Route::post('investigator/add','InvestigatorsController@create');
        Route::get('edit-profile','AccountsController@edit_profile');
        Route::get('training','AccountsController@training');
        Route::post('update-profile','AccountsController@update_profile');  
        Route::post('profile-photo','AccountsController@upload_profile_photo');  
        Route::get('specialization/{id}','SpecializationsController@index');  
        Route::get('trial/{id}/{waitlist?}','TrailsController@index');
        Route::post('apply','ApplicationsController@apply');  
        Route::get('my-applications','ApplicationsController@applications');  
        Route::post('post-application','ApplicationsController@post_applications'); 
        
        Route::get('application/{id}/download','ApplicationsController@download');  
        
        
        Route::get('messages','MessagesController@index'); 
        Route::post('send-message','MessagesController@send_message'); 
        //Route::get('message/{id}','MessagesController@single'); 
        /*complete profile middleware*/
        
        
        Route::get('referrals','ReferralsController@referrals');
        Route::post('referral/new','ReferralsController@create_referral');
        Route::post('referral/colleague','ReferralsController@create_internal_referral');
        
        Route::post('set-reminder','RemindersController@set_reminder');
    
    
        Route::get('/','AccountsController@dashboard');
        Route::post('complete-profile','AccountsController@complete_profile');
        Route::get('get-updated','TrailsController@get_latest_ajax');

        Route::get('open-trials','AccountsController@opentrials');
        Route::get('closed-trials','AccountsController@closedtrials');
        
        
        Route::get('referral/application/{id}','ReferralsController@referral_application');
        Route::post('callback-request','InfoController@callback_request');
        
        Route::group([
            'prefix' => 'finances',
            'middleware' => 'partner'
        ],function(){
            Route::get('/','FinancesController@index');  
        });
        
        
        /*clinic admin*/
        Route::group([
            'prefix' => 'clinic'
        ],function(){
            Route::get('users','ClinicController@users');
            Route::get('users/{id}','ClinicController@user_edit');
            Route::post('users/update','ClinicController@update');
            Route::post('user/delete','ClinicController@delete');
            Route::get('user/{id}','ClinicController@user');
            Route::get('add-user','ClinicController@add_user');
            Route::post('create-user','ClinicController@create_user');
        });

        Route::group(['prefix'  => 'ajax'],function() {
            Route::post('users/add', 'AccountsController@create_additional_user');
        });
        
});