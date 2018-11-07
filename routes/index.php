<?php

/*
|--------------------------------------------------------------------------
| Index Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register index web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "index" middleware group.
|
*/

//Get index page
Route::get('/', function () {
    return view('index');
});

//Login User
Route::post('login', 'AuthController@login');

//Ping server
Route::get('ping', function () { return response()->webApi(null); });

//Create Access Token for User's device
Route::post('create-client-token', 'UserController@createTokenForDevice');