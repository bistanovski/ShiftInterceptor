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
    
    
    //RabbitMQ related API endpoints
    //Get overview status of RabbitMQ
    Route::get('rabbitmq/status', 'RabbitMQController@getStatus');

    //Get RabbitMQ exchanges info
    Route::get('rabbitmq/exchanges', 'RabbitMQController@getExchanges');
    
    //Create new RabbitMQ exchange for current Vhost (configured in environment file)
    Route::post('rabbitmq/exchange/create', 'RabbitMQController@createExchange');

    //Delete existing RabbitMQ exchange for current Vhost (configured in environment file)
    Route::post('rabbitmq/exchange/delete', 'RabbitMQController@deleteExchange');
    
    //Get RabbitMQ bindings for current Vhost (configured in environment file)
    Route::get('rabbitmq/bindings', 'RabbitMQController@getBindings');
    
    //Create new RabbitMQ binding for current Vhost (configured in environment file)
    Route::post('rabbitmq/binding/create', 'RabbitMQController@createBinding');
    
    //Get RabbitMQ queues for current Vhost (configured in environment file)
    Route::get('rabbitmq/queues', 'RabbitMQController@getQueues');

    //Create new RabbitMQ queue for current Vhost (configured in environment file)
    Route::post('rabbitmq/queue/create', 'RabbitMQController@createQueue');

    //Delete existing RabbitMQ queue for current Vhost (configured in environment file)
    Route::post('rabbitmq/queue/delete', 'RabbitMQController@deleteQueue');
    
    //Clear content of the provided queue
    Route::post('rabbitmq/queue/clear-content', 'RabbitMQController@clearContent');

    
    //Settings related API endpoints
    Route::get('settings', 'SettingsController@getSettings');
});