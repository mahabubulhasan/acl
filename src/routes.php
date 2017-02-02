<?php
Route::group(['middleware' => ['web', 'auth.acl'],'namespace'=>'Uzzal\Acl\Http'], function () {    
    Route::get('role','RoleController@index');
    Route::get('role/create','RoleController@create');
    Route::post('role/store','RoleController@store');
    Route::get('role/edit/{id}','RoleController@edit');
    Route::post('role/update/{id}','RoleController@update');
    Route::get('role/destroy/{id}','RoleController@destroy');
    
    Route::get('resource','ResourceController@index');
    Route::get('resource/create','ResourceController@create');
    Route::post('resource/store','ResourceController@store');
    Route::get('resource/edit/{id}','ResourceController@edit');
    Route::post('resource/update/{id}','ResourceController@update');
    Route::get('resource/destroy/{id}','ResourceController@destroy');
});
