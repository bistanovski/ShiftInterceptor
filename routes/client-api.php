<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Client API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "client-api" middleware group.
|
*/

Route::group(['prefix' => 'v1'], function () {

    Route::get('check', function (Request $request) {
        return response()->webApi(['checked' => true]);
    });
});