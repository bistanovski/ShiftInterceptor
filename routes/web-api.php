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
    
    //Get all Users
    Route::get('users', 'UserController@getUsers');

    //Update User
    Route::post('user/update', 'UserController@updateUser');

    //Logout User
    Route::post('logout', 'AuthController@logout');
});