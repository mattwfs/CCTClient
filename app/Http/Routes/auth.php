<?php
Route::group(['middleware' => 'auth'], function () {
    Route::get('logout','AccountsController@logout');
    Route::get('change-password','AccountsController@change_password_page');
    Route::post('change-password','AccountsController@change_password');
    Route::post('ajax-upload-file','MessagesController@send_file');
    Route::post('user-has-applied','ApplicationsController@has_applied');
    Route::get('user-has-applied/{user_id}/{trial_id}/{investigator_id}','ApplicationsController@has_applied_test');
});