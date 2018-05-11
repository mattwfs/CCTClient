<?php
// users routes
Route::group([
    'prefix' => 'sales_manager',
    'middleware' => 'role:sales_manager'],
    function () {
        Route::get('/','SalesManager\SalesController@index');
        Route::get('clinics','SalesManager\SalesController@clinics');
        Route::get('clinic/{id}','SalesManager\SalesController@clinic');
        Route::post('clinic/update','SalesManager\ClinicsController@clinic_update');
        Route::get('clinics/{id}','SalesManager\UsersController@clinic_edit');
        Route::get('user/{id}','SalesManager\UsersController@index');
        Route::get('users/{id}','SalesManager\UsersController@edit');
        Route::get('add-clinic','SalesManager\UsersController@add');
        Route::get('open-trials','SalesManager\SalesController@opentrials');
        Route::post('add-clinic','SalesManager\UsersController@create');
        Route::get('trial/{id}','SalesManager\TrailsController@index');
        Route::get('financials','SalesManager\SalesController@finances');
        Route::post('associate-clinic','SalesManager/UsersController@associate_clinic');
        Route::post('referral/new','ReferralsController@create_referral');

        Route::group(['prefix'  => 'ajax'],function(){
            Route::post('clinics/add','SalesManager\ClinicsController@create');
            Route::post('users/add','SalesManager\UsersController@create');
        });
        
});