<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| WEB API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "web-api" middleware group.
|
*/

Route::group(['prefix' => 'v1'], function () {
    
    //Users related API endpoints
    
    //Get all Users
    Route::get('users', 'UserController@getUsers');

    //Create User
    Route::post('user/register', 'UserController@createUser');

    //Update User
    Route::post('user/update', 'UserController@updateUser');
    
    //Delete User
    Route::post('user/delete', 'UserController@deleteUser');

    //Logout User
    Route::post('logout', 'AuthController@logout');


    //Devices related API endpoints
    
    //Get all Devices
    Route::get('devices', 'DeviceController@getDevices');

    //Register Device
    Route::post('device/register', 'DeviceController@registerDevice');

    //Delete Device
    Route::post('device/delete', 'DeviceController@deleteDevice');


    //UserDeviceRegistrations related API endpoints
    Route::get('registrations', 'DeviceRegistrationsController@getRegistrations');
    
    
    //Settings related API endpoints
    Route::get('settings', 'SettingsController@getSettings');
});