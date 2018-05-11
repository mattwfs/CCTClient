<?php
// users routes
Route::group([
    'prefix' => 'rep',
    'middleware' => 'role:sales_rep'],
    function () {
        
        Route::get('/','Sales\SalesController@index');
        Route::get('clinics','Sales\SalesController@clinics');
        Route::get('clinic/{id}','Sales\SalesController@clinic');
        Route::get('specialization/{id}','Sales\SpecializationsController@index');
        Route::post('clinic/update','Sales\ClinicsController@clinic_update');
        Route::get('clinics/{id}','Sales\UsersController@clinic_edit');
        Route::get('user/{id}','Sales\UsersController@index');
        Route::post('users/update','Sales\UsersController@update');
        Route::get('users/{id}','Sales\UsersController@edit');
        Route::get('add-clinic','Sales\UsersController@add');
        Route::get('open-trials','Sales\SalesController@opentrials');
        Route::post('add-clinic','Sales\UsersController@create');
        Route::get('trial/{id}','Sales\TrailsController@index');
        Route::get('financials','Sales\SalesController@finances');
        Route::post('associate-clinic','Sales/UsersController@associate_clinic');
        Route::post('referral/new','ReferralsController@create_referral');

        Route::group(['prefix'  => 'ajax'],function(){
            Route::post('clinics/add','Sales\ClinicsController@create');
            Route::post('users/add','Sales\UsersController@create');
        });
        
});