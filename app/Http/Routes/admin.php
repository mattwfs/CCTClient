<?php
/*admin routes*/
Route::group([
        'prefix' => 'admin',
        'middleware' => 'role:admin',
        'namespace' => 'Admin'
    ],
    function () {
        
    Route::get('/','AccountsController@dashboard');
    
    Route::get('users','UsersController@list_all');
    Route::get('all-users','UsersController@all_users');
    Route::get('referrals','ReferralsController@referrals');
    Route::get('referrals/{id}','ReferralsController@edit');
    Route::get('sales-rep','UsersController@list_sales_rep');
    Route::get('sales-rep/{id}','UsersController@list_clinic');
    Route::get('sales-rep/edit/{id}','UsersController@sales_edit');
    Route::get('sales-manager/{id}','UsersController@sales_manager');
    Route::get('clinic/{id}','UsersController@clinic_users');
    Route::get('clinics/{id}','ClinicsController@edit');
    Route::post('clinic/update','ClinicsController@update');
    Route::post('referrals/update','ReferralsController@update');
    Route::post('location/add','ClinicsController@location_create');
    Route::post('location/delete','ClinicsController@location_delete');
    Route::get('users/{id}','UsersController@edit');
    Route::get('user/agreement/{id}','UsersController@user_agreement_page');
    Route::post('user/agreement','UsersController@user_agreement_post');
    Route::post('user/delete','UsersController@delete');
    Route::post('clinic/delete','ClinicsController@delete');
    Route::post('users/update','UsersController@update');
    
    
    Route::get('specializations','SpecializationsController@list_all');
    Route::get('specializations/{id}','SpecializationsController@edit');
    Route::post('specializations/update','SpecializationsController@update');

    Route::get('awarded','AwardedController@list_all');
    Route::get('trials','TrialsController@list_all');
    Route::get('trials/{id}','TrialsController@edit');
    Route::post('trail/delete','TrialsController@delete');
    Route::post('application/delete','ApplicationsController@delete');
    Route::post('trial/question/add','TrialsController@add_question');
    Route::post('trials/update','TrialsController@update');
    Route::get('trial/{id}/applications','ApplicationsController@trial');
    Route::get('application/{id}/download','ApplicationsController@download');
        
    Route::get('application/{id}','ApplicationsController@single');
    Route::get('applications','ApplicationsController@index');
    Route::get('applications/all','ApplicationsController@all');
    Route::get('applications/processed','ApplicationsController@processed');
    Route::get('applications/waitlist','ApplicationsController@waitlist');
    Route::get('selected-applications','ApplicationsController@applications_selected');
    Route::get('rejected-applications','ApplicationsController@applications_rejected');
    Route::post('application-status','ApplicationsController@update_status');
    Route::post('application-note','ApplicationsController@update_note');
        
    Route::get('message/{user_id}','MessagesController@index');
    Route::get('group-message/{trial_id}','MessagesController@group_message_page');
    Route::post('group-message','MessagesController@group_message_post');
    Route::get('messages','MessagesController@conversations');
    Route::get('conversation/{id}','MessagesController@conversation');
    Route::post('post-message','MessagesController@post_message');
    Route::post('send-message','MessagesController@send_message');
        
    Route::get('user/{id}','UsersController@profile');
    Route::post('add-finance','UsersController@add_finance');
    Route::get('settings','SettingsController@index');
    
        /*ajax calls*/
    Route::group(['prefix'  => 'ajax'],function(){
        Route::post('associate-sales-rep','UsersController@associate_sales_rep');
        Route::post('associate-clinic','UsersController@associate_clinic');
        Route::post('clinics/add','ClinicsController@create');
        Route::post('users/add','UsersController@create');
        Route::post('specializations/add','SpecializationsController@create');
        Route::post('trials/add','TrialsController@create');
        Route::post('trials/add-historical','TrialsController@create_historical');
        Route::post('update_receive_financials','UsersController@update_receive_financials');
        Route::post('update_receive_emails','UsersController@update_receive_emails');
    });
        
        
    } // end of anononimous function
);